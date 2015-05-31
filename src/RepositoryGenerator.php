<?php namespace SKAgarwal\Generators;

use SKAgarwal\Generators\Traits\RepositoryGeneratableTrait;

class RepositoryGenerator extends Generator
{
    use RepositoryGeneratableTrait {
        config as repoConfig;
    }

    /**
     * repository name
     *
     * @var string
     */
    private $repo;

    public function generate($model, $repo)
    {
        $this->repo = ucfirst($repo);
        $this->config($model);

        $this->makeModelDirectory();
        $this->makeSubDirectory('Repositories');
        $this->makeSubDirectory('Contracts');
        $this->makeRepositoryContract($this->modelPath);
        $this->makeEloquentRepository($this->modelPath);

    }

    protected function config($model)
    {
        parent::config($model);
        // if repo is provided use it, else model will be the repo
        $repo = $this->repo ?: $this->model;
        $this->repoConfig($this->model, $repo);
    }
}
