<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GreaterOrEqual implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->where($field, '>=', $value);
		$join === 'or' && $query->orWhere($field, '>=', $value);
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->where($field, '>=', $value);
	}
}
