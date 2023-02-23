<?php

namespace TomatoPHP\TomatoRelationManager\Services\Generator\Concerns;

use Illuminate\Support\Str;

trait GenerateRelation
{
    private function generateRelation(): void
    {
        $this->generateStubs(
            $this->stubPath . "relation.stub",
            $this->moduleName ? module_path($this->moduleName). "/RelationManager/{$this->adaptTitle}Relation.php" : app_path("RelationManager/{$this->modelName}Relation.php"),
            [
                "className" => "{$this->adaptTitle}Relation",
                "title" => $this->title,
                "tableName" => "{$this->adaptTitle}Table",
                "use" => $this->moduleName ? "Modules\\".$this->moduleName."\\Tables\RelationManager\\"."{$this->adaptTitle}Table" : "App\\Tables\\RelationManager\\"."{$this->adaptTitle}Table",
                "relationName" => $this->relationName,
                "namespace" => $this->moduleName ? "Modules\\".$this->moduleName."\\RelationManager" : "App\\RelationManager",
            ],
            [
                $this->moduleName ? module_path($this->moduleName)."/RelationManager" : app_path("RelationManager")
            ]
        );
    }

}
