<?php

declare(strict_types=1);

namespace IsaqueSb\Filters;

class ListParams
{
	public Filter $filter;

	public ?Limiter $limiter = null;

	public ?Sorter $sorter = null;

    public function __construct(Filter $filter, ?Limiter $limiter = null, ?Sorter $sorter = null)
    {
		$this->filter = $filter;
		$this->limiter = $limiter;
		$this->sorter = $sorter;
    }
}
