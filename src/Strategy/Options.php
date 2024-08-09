<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Strategy;

use Illuminate\Http\Request;

class Options
{
	public Request $request;

	public array $allowedFields = [];

	public array $defaultOperators = [];

	public array $defaultSort = [];

	public int $defaultPerPage = 20;

	public string $perPageKey = 'per_page';

	public string $pageKey = 'page';

	public string $sortKey = 'sort';

	public function withFields(array $fields): self
	{
		$this->allowedFields = $fields;
		return $this;
	}

	public function withDefaultSort(array $sorts): self
	{
		$this->defaultSort = $sorts;
		return $this;
	}
}
