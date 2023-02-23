<?php

namespace TomatoPHP\TomatoRelationManager\Services\Generator\Concerns;

use Illuminate\Support\Str;

trait GenerateTable
{
    private function generateTable(): void
    {
        $this->generateStubs(
            $this->stubPath . "table.stub",
            $this->moduleName ? module_path($this->moduleName). "/Tables/RelationManager/{$this->adaptTitle}Table.php" : app_path("Tables/RelationManager/{$this->modelName}Table.php"),
            [
                "name" => "{$this->adaptTitle}Table",
                "title" => $this->modelName,
                "model" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Entities\\".$this->modelName :"\\App\\Models\\".$this->modelName,
                "searchable" => $this->generateSearchable(),
                "cols" => $this->generateCols(),
                "namespace" => $this->moduleName ? "Modules\\".$this->moduleName."\\Tables\RelationManager" : "App\\Tables\RelationManager",
            ],
            [
                $this->moduleName ? module_path($this->moduleName)."/Tables/RelationManager" : app_path("Tables/RelationManager")
            ]
        );
    }

    private function generateSearchable(): string
    {
        $searchable = "";
        foreach($this->cols as $key=>$item){
            if($item['unique']){
                $searchable .= "'{$item['name']}',";
            }
            else if($item['name'] === 'id'){
                $searchable .= "'{$item['name']}',";
            }
            else if($item['name'] === 'name'){
                $searchable .= "'{$item['name']}',";
            }
            else if($item['name'] === 'phone'){
                $searchable .= "'{$item['name']}',";
            }
            else if($item['name'] === 'email'){
                $searchable .= "'{$item['name']}',";
            }
            else if($item['type'] === 'relation'){
                $searchable .= "'".Str::remove('_id', $item['name']).".".$item['relation']['relationColumn']."',";
            }
        }

        return $searchable;
    }

    private function generateCols(): string
    {
        $cols = "";
        foreach($this->cols as $key=>$item){
            if($item['name'] !== 'password'){
                if($key!== 0){
                    $cols .= "            ";
                }
                $cols .= $this->checkColumnForRelation($item);
                if($key!== count($this->cols)-1){
                    $cols .= PHP_EOL;
                }
            }
        }
        return $cols;
    }
    private function checkColumnForRelation(array $item){
        $column="->column(
                key: '".$item['name']."',
                label: __('".Str::of($item['name'])->replace('_',' ')->ucfirst()."'),
                sortable: true)";
            if ($item['type'] == 'relation'){
                $column= "->column(
                key: '".Str::remove('_id', $item['name']).".".$item['relation']['relationColumn']."',
                label: __('".Str::of($item['name'])->remove('_id')->replace('_',' ')->ucfirst()."'),
                sortable: true,
                searchable: true)";
            }
        return $column;
    }
}
