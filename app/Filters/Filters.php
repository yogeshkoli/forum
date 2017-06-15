<?php

namespace App\Filters;

use Illuminate\Support\Facades\Request;

abstract class Filters
{
    protected $request, $builder;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     */
    public function apply($builder)
    {

        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return request()->intersect($this->filters);
    }
}