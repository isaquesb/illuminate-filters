<?php

declare(strict_types=1);

namespace IsaqueSb\Filters;

class Limiter
{
	public int $perPage = 100;

	public int $offset = 0;

	/**
	 * @param int $perPage
	 * @param int $offset
	 */
	public function __construct(int $perPage, int $offset)
	{
		$this->perPage = $perPage;
		$this->offset = $offset;
	}
}
