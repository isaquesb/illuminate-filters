<?php

declare(strict_types=1);

namespace IsaqueSb\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Filter
{
    public Collection $items;

	/**
	 * @param array|Collection $items
	 */
    public function __construct($items)
    {
        $this->items = ($items instanceof Collection ? $items : collect($items))
            ->map(fn ($item) => $item instanceof Item ? $item : new Item(...$item));
    }

	/**
	 * @param Builder|Collection $target
	 * @return Builder|Collection
	 * @throws \Exception
	 */
    public function apply($target)
    {
        if ($target instanceof Builder) {
			$target->where(fn ($query) => $this->items->each(fn (Item $item) => $this->applyItemInQuery($item, $query)));
            return $target;
        }

        return $this->items->each(fn (Item $item) => $this->applyItemInCollection($item, $target));
    }

	/**
	 * @throws \Exception
	 */
	private function applyItemInQuery(Item $item, Builder $target): void
    {
		if ($item->isGroup()) {
			$isOr = $item->join === 'or';
			$callWhere = $isOr ? 'orWhere' : 'where';
			$target->{$callWhere}(fn ($subQuery) =>
				$item->value->each(fn ($singleCondition) => $this->applyItemInQuery($singleCondition, $subQuery))
			);
			return;
		}

		$operator = Operator\Factory::create($item->operator);
		if (!$operator instanceof Operator\ForQuery) {
			throw new \Exception('Operator ' . $item->operator . ' is not for query');
		}
		$operator->queryApply($target, $item->field, $item->value, $item->join);
    }

	/**
	 * @throws \Exception
	 */
	private function applyItemInCollection(Item $item, Collection $target): void
    {
		if ($item->isGroup()) {
			$cloned = new Collection($target->all());
			$groupConditions = $item->value;
			$isOr = $item->join === 'or';
			$filtered = $cloned->filter(function ($row) use ($groupConditions, $isOr) {
				$matches = 0;
				foreach ($groupConditions as $singleCondition) {
					$testTarget = new Collection([$row]);
					$this->applyItemInCollection($singleCondition, $testTarget);
					$matches += $testTarget->count(); // 0 or 1
				}
				return $isOr ? $matches > 0 : $matches === count($groupConditions);
			});
			$target->replace($filtered);
			return;
		}

		$operator = Operator\Factory::create($item->operator);
		if (!$operator instanceof Operator\ForCollection) {
			throw new \Exception('Operator ' . $item->operator . ' is not for collection');
		}
		$filtered = $operator->collectionApply($target, $item->field, $item->value);
		$target->replace($filtered);
    }
}
