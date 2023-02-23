<?php

namespace TomatoPHP\TomatoRelationManager\Services\Generator\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait GenerateFolders
{
    private function generateFolders(): void
    {
        if($this->moduleName){
            $folders = [

                module_path($this->moduleName)."/RelationManager",
                module_path($this->moduleName)."/Tables/RelationManager"
            ];
        }
        else {
            $folders = [
                app_path("Tables/RelationManager"),
                app_path("RelationManager"),
            ];
        }

        foreach($folders as $folder){
            if(!File::exists($folder)){
                File::makeDirectory($folder);
            }
        }
    }
}
