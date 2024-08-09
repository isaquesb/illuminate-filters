<?php

declare(strict_types=1);

namespace IsaqueSb\Filters\Strategy;

use Illuminate\Http\Request;

class Factory
{
	protected static array $strategyClassMap = [
		'default' => DefaultStrategy::class,
	];

	public static function create(string $strategy): Strategy
	{
		if (!isset(static::$strategyClassMap[$strategy])) {
			throw new \InvalidArgumentException("Unknown strategy: {$strategy}");
		}

		$strategyClass = static::$strategyClassMap[$strategy];

		return new $strategyClass;
	}

	public static function register(string $strategy, string $strategyClass): void
	{
		static::$strategyClassMap[$strategy] = $strategyClass;
	}

	public static function unregister(string $strategy): void
	{
		unset(static::$strategyClassMap[$strategy]);
	}

	public static function createFromRequest(Request $request): Strategy
	{
		$strategy = $request->header('X-Filter-Strategy', 'default');
		return static::create($strategy);
	}
}
