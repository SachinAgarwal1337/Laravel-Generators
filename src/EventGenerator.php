<?php namespace SKAgarwal\Generators;

use Illuminate\Support\Facades\Artisan;
use SKAgarwal\Generators\Traits\NamespacingTrait;

class EventGenerator extends Generator
{
    use NamespacingTrait;

    /**
     * @var string
     */
    protected $event;

    /**
     * Generate Event
     *
     * @param $name
     * @param $model
     */
    public function generate($name, $model)
    {
        $this->name - ucfirst($name);
        $this->config($model);

        Artisan::call('make:event', ['name' => $this->event]);
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * Configure Event Generator
     *
     * @param $model
     */
    protected function config($model)
    {
        parent::config($model);

        $this->setEvent("{$this->namespace}{$this->model}\\Events\\{$this->name}");
    }
}
