<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class NotBetween implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->whereNotBetween($field, $value);
		$join === 'or' && $query->orWhereNotBetween($field, $value);
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->whereNotBetween($field, $value);
	}
}
