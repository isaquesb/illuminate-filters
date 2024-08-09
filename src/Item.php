<?php

declare(strict_types=1);

namespace IsaqueSb\Filters;

class Item
{
	public string $field;

	/**
	 * @var null|mixed $value
	 */
	public $value = null;

	public string $operator = '=';

	public string $join = 'and';

    public function __construct(string $field, $value = null, string $operator = '=')
    {
		$this->field = $field;
		$this->value = $value;
		$this->operator = $operator;
    }

	public function isGroup(): bool
	{
		return $this instanceof ItemGroup;
	}
}
