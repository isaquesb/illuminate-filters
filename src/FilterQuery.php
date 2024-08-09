<?php

namespace IsaqueSb\Filters;

use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait FilterQuery
{
	/**
	 * @param ListParams $params
	 * @param Builder $query
	 * @param array|null $cols
	 * @param \Closure|null $mapToResults
	 * @return PaginatorContract|Collection
	 * @throws \Exception
	 */
	protected function applyFilters(ListParams $params, Builder $query,  ?array $cols, ?\Closure $mapToResults = null)
	{
		$params->filter->apply($query);
		if ($params->sorter) {
			$params->sorter->sort($query);
		}

		if ($params->limiter) {
			$paginator = $query->paginate(
				$params->limiter->perPage,
				$cols,
				'page',
				$params->limiter->offset / $params->limiter->perPage + 1
			);
			$items = collect($paginator->items());
			if ($mapToResults) {
				$items = $items->map($mapToResults);
			}
			$paginator->setCollection($items);
			return $paginator;
		}
		$items = $query->get($cols);
		if ($mapToResults) {
			$items = $items->map($mapToResults);
		}
		return $items;
	}

	protected function withColumnAliases(ListParams $params, $aliases): ListParams
	{
		$getInMap = fn ($column) => $aliases[$column] ?? $column;
		if ($params->sorter) {
			$params->sorter->sortBy = collect($params->sorter->sortBy)
				->mapWithKeys(fn ($value, $key) => [$getInMap($key) => $getInMap($value)])
				->toArray();
		}
		$newItems = $params->filter->items
			->mapWithKeys(fn ($value, $key) => [$key => $this->itemWithNewField($value, $aliases)]);
		$params->filter->items = $newItems;
		return $params;
	}

	private function itemWithNewField($item, array $aliases)
	{
		if ($item->isGroup()) {
			$newItems = $item->value
				->map(fn ($value) => $this->itemWithNewField($value, $aliases));
			$newItem = clone $item;
			$newItem->value = $newItems;
			return $newItem;
		}
		if (!isset($aliases[$item->field])) {
			return $item;
		}
		$newItem = clone $item;
		$newItem->field = $aliases[$item->field];
		return $newItem;
	}
}
