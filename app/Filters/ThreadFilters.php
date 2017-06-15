<?php

namespace App\Filters;

use App\User;
use Illuminate\Support\Facades\Request;

/**
 * Class ThreadFilters
 * @package App\Filters
 */
class ThreadFilters extends Filters
{

    protected $filters = ['by'];

    /**
     * filter the query by given username
     *
     * @param string $username
     *
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where(['user_id' => $user->id]);
    }
}