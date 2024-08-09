<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Operator;

use Illuminate\Support\Str;

class Factory
{
	protected static array $operatorClassMap = [
		'less' => Less::class,
		'less_or_equal' => LessOrEqual::class,
		'greater' => Greater::class,
		'greater_or_equal' => GreaterOrEqual::class,
		'equal' => Equal::class,
		'not_equal' => NotEqual::class,
		'contains' => Contains::class,
		'not_contains' => NotContains::class,
		'in' => In::class,
		'not_in' => NotIn::class,
		'between' => Between::class,
		'not_between' => NotBetween::class,
		'is_null' => IsNull::class,
		'is_not_null' => IsNotNull::class,
		'starts_with' => StartsWith::class,
		'not_starts_with' => NotStartsWith::class,
		'ends_with' => EndsWith::class,
		'not_ends_with' => NotEndsWith::class,
	];

	protected static array $aliases = [
		'<' => 'less',
		'<=' => 'less_or_equal',
		'>' => 'greater',
		'>=' => 'greater_or_equal',
		'=' => 'equal',
		'!=' => 'not_equal',
		'<>' => 'not_equal',
		'like' => 'contains',
		'not_like' => 'not_contains',
	];

	public static function create(string $operator)
	{
		$operator = static::$aliases[$operator] ?? $operator;
		$snaked = Str::snake(Str::lower($operator));
		if (!isset(static::$operatorClassMap[$snaked])) {
			throw new \InvalidArgumentException("Operator {$operator} is not supported");
		}

		return new static::$operatorClassMap[$snaked];
	}
}
