<?php

namespace TomatoPHP\TomatoRelationManager\Console;

use Illuminate\Console\Command;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;
use TomatoPHP\TomatoRelationManager\Services\Generator\CRUDGenerator;

class TomatoRelationManagerInstall extends Command
{
    use RunCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'tomato-relation-manager:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $relationName = $this->ask('🍅 Please input your relation function name that exist in your model? (ex: comment)');
        $title = $this->ask('🍅 Please input a title? (ex: Post Comments)');
        //Get Table Name
        $check = true;
        while ($check) {
            $tableName = $this->ask('🍅 Please input your table name you went to create CRUD? (ex: comments)');


            if (\Illuminate\Support\Facades\Schema::hasTable($tableName)) {
                $check = false;
            } else {
                $this->error("Sorry table not found!");
            }
        }

        //Check if user need to use HMVC
        $isModule = $this->ask('🍅 Do you went to use HMVC module? (y/n)', 'y');
        if (!$isModule) {
            $isModule = 'y';
        }
        $moduleName = false;
        if ($isModule === 'y') {
            $moduleName = $this->ask('🍅 Please input your module name? (ex: Translations)');
            if ($moduleName) {
                if (class_exists(\Nwidart\Modules\Facades\Module::class)) {
                    $check = \Nwidart\Modules\Facades\Module::find($moduleName);
                    if (!$check) {
                        $this->info("🍅 Module not found but we will create it for you ");
                        $this->artisanCommand(["module:make", $moduleName]);
                    }
                } else {
                    $this->error("🍅 Sorry nwidart/laravel-modules not installed please install it first");
                }
            }
        }

        //Generate CRUD Service
        try {
            $resourceGenerator = new CRUDGenerator($tableName,$moduleName, $relationName, $title);
            $resourceGenerator->generate();
            $this->info('🍅 Relation Has Been Generated Success');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

    }
}
