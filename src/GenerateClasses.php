<?php namespace SKAgarwal\Generators;

use Artisan;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\AppNamespaceDetectorTrait;

class GenerateClasses
{
    use AppNamespaceDetectorTrait;

    /**
     * @var Filesystem
     */
    private $file;

    /**
     * Requested Model Name
     *
     * @var string
     */
    private $model;

    /**
     * Model Class path
     *
     * @var string
     */
    private $modelPath;

    /**
     * Model Class Name
     *
     * @var string
     */
    private $modelClassName;

    /**
     * Contract/Interface Name
     *
     * @var string
     */
    private $contractName;

    /**
     * Repository Class Name
     *
     * @var string
     */
    private $repositoryName;

    /**
     * Contract/Interface Namespace
     *
     * @var string
     */
    private $contractNamespace;

    /**
     * Repository Class Namespace
     *
     * @var string
     */
    private $repositoryNameSpace;

    /**
     * @param Filesystem $file
     */
    public function __construct(Filesystem $file)
    {
        $this->file = $file;
    }

    /**
     * @param string $model
     */
    private function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param string $modelPath
     */
    private function setModelPath($modelPath)
    {
        $this->modelPath = $modelPath;
    }

    /**
     * @param string $modelClassName
     */
    private function setModelClassName($modelClassName)
    {
        $this->modelClassName = $modelClassName;
    }

    /**
     * @param string $contractName
     */
    private function setContractName($contractName)
    {
        $this->contractName = $contractName;
    }

    /**
     * @param string $repositoryName
     */
    private function setRepositoryName($repositoryName)
    {
        $this->repositoryName = $repositoryName;
    }

    /**
     * @param string $contractNamespace
     */
    private function setContractNamespace($contractNamespace)
    {
        $this->contractNamespace = $this->getAppNamespace().$contractNamespace;
    }

    /**
     * @param string $repositoryNameSpace
     */
    private function setRepositoryNameSpace($repositoryNameSpace)
    {
        $this->repositoryNameSpace
            = $this->getAppNamespace().$repositoryNameSpace;
    }

    /**
     * Generate the Directory Structure and Required Classes
     *
     * @param $model
     * @param $migration
     */
    public function generate($model, $migration)
    {
        $this->setProperties($model);

        $this->makeModelDirectory();

        $this->makeSubDirectory("Repositories");

        $this->makeSubDirectory("Contracts");

        $this->makeSubDirectory("Events");

        $this->makeSubDirectory("Listeners");

        $this->makeSubDirectory("Jobs");

        $migration = $this->isMigrationRequired($migration);
        $this->makeModelClassWithMigration($migration);

        $this->makeRepositoryContract();

        $this->makeEloquentRepository();
    }

    /**
     * Create a directory for the Requesting Model
     */
    private function makeModelDirectory()
    {
        if (!$this->exists($this->modelPath)) {
            $this->file->makeDirectory($this->modelPath);
        }
    }

    /**
     * Create subdirectories under Model Directory
     *
     * @param $subDirectory
     */
    private function makeSubDirectory($subDirectory)
    {
        $directory = "{$this->modelPath}/{$subDirectory}";

        if (!$this->exists($directory)) {
            $this->file->makeDirectory($directory);
        }
    }

    /**
     * Generate Model Class and
     * Migration if needed
     *
     * @param $migration
     *
     * @return string
     */
    private function makeModelClassWithMigration($migration)
    {
        Artisan::call('make:model', [
            'name'        => $this->modelClassName,
            '--migration' => $migration,
        ]);
    }

    /**
     * check if migration is needed
     *
     * @param $migration
     *
     * @return string
     */
    private function isMigrationRequired($migration)
    {
        return $migration ? "--migration" : '';
    }

    /**
     * Generate the Model Specific Repository Contract/Interface
     *
     * @return array
     */
    private function makeRepositoryContract()
    {
        $path = "{$this->modelPath}/Contracts/{$this->contractName}.php";

        if (!$this->exists($path)) {
            $content = $this->getRepositoryContractTemplate();

            $this->file->put($path, $content);
        }
    }

    /**
     * Generate Model Specific Eloquent Repository
     */
    private function makeEloquentRepository()
    {
        $path = "{$this->modelPath}/Repositories/{$this->repositoryName}.php";

        if (!$this->exists($path)) {
            $content = $this->getEloquentRepositoryTemplate();

            $this->file->put($path, $content);
        }
    }

    /**
     * @param $from
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function getTemplate($from)
    {
        $templatePath = __DIR__."/Templates/{$from}.txt";

        return $this->file->get($templatePath);
    }

    /**
     * Get the content for Repository Contract/Interface
     */
    private function getRepositoryContractTemplate()
    {
        $template = $this->getTemplate('RepositoryContract');

        $find = ['{{Namespace}}', '{{Interface}}'];
        $replace = [$this->contractNamespace, $this->contractName];

        return str_replace($find, $replace, $template);
    }

    /**
     * Get the content for Eloquet Repository Class
     */
    private function getEloquentRepositoryTemplate()
    {
        $template = $this->getTemplate('EloquentRepository');

        $contractNamespace = $this->contractNamespace."\\$this->contractName";

        $find = [
            '{{Namespace}}',
            '{{ContractNamespace}}',
            '{{Repository}}',
            '{{Contaract}}'
        ];

        $replace = [
            $this->repositoryNameSpace,
            $contractNamespace,
            $this->repositoryName,
            $this->contractName
        ];

        return str_replace($find, $replace, $template);
    }

    /**
     * Set all the properties of the Class
     *
     * @param $model
     */
    private function setProperties($model)
    {
        $this->setModel($model);

        $this->setModelPath("app/{$this->model}");

        $this->setModelClassName("{$this->model}/{$this->model}");

        $this->setContractName("{$this->model}Repository");

        $this->setRepositoryName("Eloquent{$this->model}Repository");

        $this->setContractNamespace("{$this->model}\\Contracts");

        $this->setRepositoryNameSpace("{$this->model}\\Repositories");
    }

    /**
     * check if the directory/file exists
     *
     * @return bool
     */
    private function exists($path)
    {
        return $this->file->exists($path);
    }
}