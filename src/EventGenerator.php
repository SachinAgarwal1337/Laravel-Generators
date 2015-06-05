<?php namespace SKAgarwal\Generators;

use Illuminate\Support\Facades\Artisan;
use SKAgarwal\Generators\Traits\EventGeneratableTrait;

class EventGenerator extends Generator
{
    use EventGeneratableTrait {
        config as eventConfig;
    }

    /**
     * Generate Event
     *
     * @param $name
     * @param $model
     */
    public function generate($name, $model)
    {
        $name - ucfirst($name);
        $this->config($model);

        Artisan::call('make:event', [
            'name' => "{$this->eventNamespace}\\{$name}"
        ]);
    }


    /**
     * Configure Event Generator
     *
     * @param $model
     */
    protected function config($model)
    {
        parent::config($model);

        $this->eventConfig($this->model, $this->namespace);
    }
}
