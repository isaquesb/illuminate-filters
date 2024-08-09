<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class In implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->whereIn($field, $value);
		$join === 'or' && $query->orWhereIn($field, $value);
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->whereIn($field, $value);
	}
}
