<?php


namespace TomatoPHP\TomatoRelationManager\Contracts;

use Illuminate\Database\Eloquent\Model;
use ProtoneMedia\Splade\AbstractTable;

abstract class RelationManagerAbstract
{
    public AbstractTable $table;
    public bool $canShow=false;
    public bool $canEdit=false;
    public bool $canDelete=false;
    public ?string $path=null;
    public string $showModal='slideover';
    public string $createModal='slideover';
    public string $editModal='slideover';


    /**
     * RelationManagerAbstract constructor.
     * take the current page model object
     * call render method
     * @param Model $ownerModel
     */
    public function __construct(protected Model $ownerModel)
    {
        $this->render();
    }

    /*
     * This function must set the TableClass into AbstractTable object
     * */
    abstract protected function render():void;
}
