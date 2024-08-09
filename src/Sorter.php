<?php

declare(strict_types=1);

namespace IsaqueSb\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Sorter
{
	public array $sortBy;

    public function __construct(array $sortBy)
    {
		$this->sortBy = $sortBy;
    }

	/**
	 * @param Builder|Collection $target
	 * @return Builder|Collection
	 */
    public function sort($target)
    {
        if ($target instanceof Builder) {
            foreach ($this->sortBy as $key => $sort) {
                $col = is_numeric($key) ? $sort : $key;
                $direction = is_numeric($key) ? 'asc' : $sort;
                $target->orderBy($col, $direction);
            }
            return $target;
        }

        $sorts = [];

        foreach ($this->sortBy as $key => $sort) {
            $col = is_numeric($key) ? $sort : $key;
            $direction = is_numeric($key) ? 'asc' : $sort;
            $isDesc = $direction === -1 || Str::lower($direction) ===  'desc';
            $sorts[] = $isDesc ? fn ($a, $b) => $b[$col] <=> $a[$col] : fn ($a, $b) => $a[$col] <=> $b[$col];
        }

        if ($sorts) {
			return $target->sortBy($sorts);
		}

        return $target;
    }
}
