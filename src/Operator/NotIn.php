<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class NotIn implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->whereNotIn($field, $value);
		$join === 'or' && $query->orWhereNotIn($field, $value);
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->whereNotIn($field, $value);
	}
}
