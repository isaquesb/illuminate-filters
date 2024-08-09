<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EndsWith implements ForQuery, ForCollection
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and')
	{
		$join === 'and' && $query->where($field, 'like', "%{$value}");
		$join === 'or' && $query->orWhere($field, 'like', "%{$value}");
	}

	public function collectionApply($collection, $field, $value = null): Collection
	{
		return $collection->filter(fn ($item) => Str::endsWith($item[$field], $value));
	}
}
