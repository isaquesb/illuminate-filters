<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Database\Eloquent\Builder;

interface ForQuery
{
	public function queryApply(Builder $query, $field, $value = null, $join = 'and');
}
