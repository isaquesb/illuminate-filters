<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Strategy;

use IsaqueSb\Filters;

class DefaultStrategy implements Strategy
{
	public function filter(Options $options): Filters\Filter
	{
		$items = collect();
		collect($options->request->only($options->allowedFields))
			->filter()
			->each(function ($value, $field) use ($items, $options) {
				$items->push(new Filters\Item($field, $value, $options->defaultOperators[$field] ?? '='));
			});
		return new Filters\Filter($items);
	}

	public function sorter(Options $options): ?Filters\Sorter
	{
		$default = $options->defaultSort;
		$sort = $options->request->get($options->sortKey);
		if (!$sort && !$default) {
			return null;
		}
		$sortList = collect();
		collect($sort ? explode(',', $sort) : $default)
			->filter()
			->map(function ($item) use ($sortList) {
				$direction = 'asc';
				if (substr($item, 0, 1) === '-') {
					$direction = 'desc';
					$item = substr($item, 1);
				}
				$sortList->offsetSet($item, $direction);
			});
		if (!$sortList->count()) {
			return null;
		}
		return new Filters\Sorter($sortList->toArray());
	}

	public function limiter(Options $options): ?Filters\Limiter
	{
		$perPage = $options->request->get($options->perPageKey, $options->defaultPerPage);
		$page = $options->request->get($options->pageKey);
		$skip = $page ? ($page - 1) * $perPage : 0;
		return new Filters\Limiter((int) $perPage, $skip);
	}

	public function listParams(Options $options): Filters\ListParams
	{
		return new Filters\ListParams(
			$this->filter($options),
			$this->limiter($options),
			$this->sorter($options)
		);
	}
}
