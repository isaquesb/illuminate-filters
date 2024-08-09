<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class IsNull implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->whereNull($field);
		$join === 'or' && $query->orWhereNull($field);
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->whereNull($field);
	}
}
