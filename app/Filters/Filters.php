<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;
    protected $builder;

    /**
     * Filters
     *
     * @var array
     */
    protected $filters = [];

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters
     *
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->{$filter}($value);
            }
        }

        return $this->builder;
    }

    /**
     * Returns filters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array_intersect(array_keys($this->request->all()), $this->filters);
        return $this->request->only($filters);
    }
}
