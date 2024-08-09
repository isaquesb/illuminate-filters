<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Strategy;

use IsaqueSb\Filters;

interface Strategy
{
	function filter(Options $options): Filters\Filter;

	function sorter(Options $options): ?Filters\Sorter;

	function limiter(Options $options): ?Filters\Limiter;

	function listParams(Options $options): Filters\ListParams;
}
