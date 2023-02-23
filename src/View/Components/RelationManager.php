<?php

namespace TomatoPHP\TomatoRelationManager\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class RelationManager extends Component
{
    public static array $managers = [];
    public static Model $ownerRecord;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Model $model, public array $relations)
    {

        foreach ($relations as $relation)
            self::$managers[] = new $relation($model);

        self::$ownerRecord = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('tomato-relation-manager::components.relation-manager');
    }
}

/*
 * TODO :can show,edit,delete
 *
 * */
