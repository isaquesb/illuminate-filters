<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class NotStartsWith implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->where($field, 'not like', $value . '%');
		$join === 'or' && $query->orWhere($field, 'not like', $value . '%');
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->filter(fn ($item) => stripos($item[$field], $value) !== 0);
	}
}
