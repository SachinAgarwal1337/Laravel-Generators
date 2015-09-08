<?php namespace SKAgarwal\Generators;

use Illuminate\Support\Facades\Artisan;
use SKAgarwal\Generators\Traits\RepositoryGeneratableTrait;

class ModelGenerator extends Generator
{
    use RepositoryGeneratableTrait {
        RepositoryGeneratableTrait::config as repoConfig;
    }

    /**
     * Model Class Name.
     *
     * @var string
     */
    protected $modelClassName;

    /**
     * Set the model class name.
     *
     * @param $modelClassName
     *
     * @return $this
     */
    protected function setModelClassName($modelClassName)
    {
        $this->modelClassName = $modelClassName;

        return $this;
    }

    /**
     * Generate the Directory Structure and Required Classes.
     *
     * @param string $model
     * @param string $migration
     */
    public function generate($model, $migration)
    {
        $this->config($model);

        $this->makeModelDirectory();

        $this->makeSubDirectory("Repositories");

        $this->makeSubDirectory("Contracts");

        $this->makeSubDirectory("Events");

        $this->makeSubDirectory("Policies");

        $this->makeSubDirectory("Listeners");

        $this->makeSubDirectory("Jobs");

        $this->makeModelClassWithMigration($migration);

        $this->makeRepositoryContract($this->modelPath);

        $this->makeEloquentRepository($this->modelPath);
    }

    /**
     * Generate Model Class and
     * Migration if needed.
     *
     * @param $migration
     *
     * @return string
     */
    private function makeModelClassWithMigration($migration)
    {
        $migration = $this->hasMigration($migration);

        Artisan::call('make:model', [
            'name'        => $this->modelClassName,
            '--migration' => $migration,
        ]);
    }

    /**
     * Check if migration is needed.
     *
     * @param $migration
     *
     * @return string
     */
    private function hasMigration($migration)
    {
        return $migration ? "--migration" : '';
    }

    /**
     * Set all the properties of the Class.
     *
     * @param string $model
     */
    protected function config($model)
    {
        parent::config($model);

        $this->setModelClassName("{$this->model}/{$this->model}");
        $this->repoConfig($this->model, $this->model, $this->namespace);
    }
}
