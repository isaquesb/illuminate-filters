<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class IsNotNull implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->whereNotNull($field);
		$join === 'or' && $query->orWhereNotNull($field);
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->whereNotNull($field);
	}
}
