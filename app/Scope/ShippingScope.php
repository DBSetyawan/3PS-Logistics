<?php

namespace warehouse\Scope;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShippingScope implements Scope
{

    private $column;

    private $direction;

    public function __construct($column, $direction = 'asc')
    {
        $this->column = $column;
        $this->direction = $direction;
    }
    
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy($this->column, $this->direction);

        // // optional macro to undo the global scope
        // $builder->macro('unordered', function (Builder $builder) {
        //     $this->remove($builder, $builder->getModel());
        //     return $builder;
        // });
    }
}