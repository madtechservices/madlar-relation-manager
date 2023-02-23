<?php

namespace TomatoPHP\TomatoRelationManager\Services\Generator;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Illuminate\Support\Str;
use TomatoPHP\ConsoleHelpers\Traits\HandleStub;
use TomatoPHP\TomatoRelationManager\Services\Generator\Concerns\GenerateCols;
use TomatoPHP\TomatoRelationManager\Services\Generator\Concerns\GenerateFolders;
use TomatoPHP\TomatoRelationManager\Services\Generator\Concerns\GenerateModel;
use TomatoPHP\TomatoRelationManager\Services\Generator\Concerns\GenerateRelation;
use TomatoPHP\TomatoRelationManager\Services\Generator\Concerns\GenerateTable;


class CRUDGenerator
{
    private string $modelName;
    private string $stubPath;
    private array $cols;
    public string $adaptTitle;

    //Handler
    use HandleStub;
    use GenerateFolders;
    use GenerateRelation;
    use GenerateModel;
    use GenerateTable;
    use GenerateCols;


    private Connection $connection;

    /**
     * @param string $tableName
     * @param string|bool|null $moduleName
     * @throws Exception
     */
    public function __construct(
        private string           $tableName,
        private string|bool|null $moduleName,
        private string|bool|null $relationName,
        private string|bool|null $title,
    )
    {
        $connectionParams = [
            'dbname' => config('database.connections.mysql.database'),
            'user' => config('database.connections.mysql.username'),
            'password' => config('database.connections.mysql.password'),
            'host' => config('database.connections.mysql.host'),
            'driver' => 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        $this->modelName = Str::ucfirst(Str::singular(Str::camel($this->tableName)));
        $this->adaptTitle = Str::ucfirst(Str::singular(Str::camel($this->tableName)));
        $this->stubPath = config('tomato-relation-manager.stubs-path') . "/";
        $this->cols = $this->getCols();
    }

    /**
     * @return void
     */
    public function generate(): void
    {
        $this->generateFolders();
        $this->generateModel();
        $this->generateTable();
        $this->generaterelation();

    }

    /*
     * TODO: Implement icons ,counters ,sync ,attach,cruds on table
     * TODO: Implement all ubove with custom query function
     * */

}
