<?php namespace SKAgarwal\Generators;

use Artisan;
use SKAgarwal\Generators\Traits\RepositoryGeneratableTrait;

class ModelGenerator extends Generator
{
    use RepositoryGeneratableTrait {
        RepositoryGeneratableTrait::config as repoConfig;
    }

    /**
     * Model Class Name
     *
     * @var string
     */
    protected $modelClassName;

    /**
     * @param string $modelClassName
     */
    protected function setModelClassName($modelClassName)
    {
        $this->modelClassName = $modelClassName;
    }

    /**
     * Generate the Directory Structure and Required Classes
     *
     * @param $model
     * @param $migration
     */
    public function generate($model, $migration)
    {
        $this->config($model);

        $this->makeModelDirectory();

        $this->makeSubDirectory("Repositories");

        $this->makeSubDirectory("Contracts");

        $this->makeSubDirectory("Events");

        $this->makeSubDirectory("Listeners");

        $this->makeSubDirectory("Jobs");

        $migration = $this->isMigration($migration);
        $this->makeModelClassWithMigration($migration);

        $this->makeRepositoryContract($this->modelPath);

        $this->makeEloquentRepository($this->modelPath);
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
    private function isMigration($migration)
    {
        return $migration ? "--migration" : '';
    }


    /**
     * Set all the properties of the Class
     *
     * @param $model
     */
    protected function config($model)
    {
        parent::config($model);

        $this->setModelClassName("{$this->model}/{$this->model}");
        $this->repoConfig($model);

    }


}