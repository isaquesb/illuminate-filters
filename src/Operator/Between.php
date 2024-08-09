<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Between implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->whereBetween($field, $value);
		$join === 'or' && $query->orWhereBetween($field, $value);
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->whereBetween($field, $value);
	}
}
