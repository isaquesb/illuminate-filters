<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Support\Collection;

interface ForCollection
{
	public function collectionApply(Collection $collection, $field, $value = null) : Collection;
}
