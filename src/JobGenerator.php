<?php namespace SKAgarwal\Generators;

use Illuminate\Support\Facades\Artisan;
use SKAgarwal\Generators\Traits\JobGeneratableTrait;

class JobGenerator extends Generator
{
    use JobGeneratableTrait {
        config as jobConfig;
    }

    /**
     * Generate a Job.
     *
     * @param $name
     * @param $options
     */
    public function generate($name, $options)
    {
        $this->config($options['model']);
        $name = ucfirst($name);
        $queued = $this->isQueued($options['queued']);

        Artisan::call('make:job', [
            'name'     => "{$this->jobNamespace}\\{$name}",
            '--queued' => $queued
        ]);

    }

    /**
     * Check if the Job should be queued.
     *
     * @param $queued
     *
     * @return string
     */
    private function isQueued($queued)
    {
        return $queued ? '--queued' : '';
    }

    /**
     * Configure the Job generator.
     *
     * @param $model
     */
    protected function config($model)
    {
        parent::config($model);

        $this->jobConfig($this->model, $this->namespace);
    }
}
