<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    /**
     * Filters
     *
     * @var array
     */
    protected $filters = ['by'];

    /**
     * Filter a query by a given username
     *
     * @param string $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
