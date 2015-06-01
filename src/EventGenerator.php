<?php namespace SKAgarwal\Generators;

use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Support\Facades\Artisan;

class EventGenerator
{
    use AppNamespaceDetectorTrait;

    protected $eventNamespace;

    public function generate($event, $model)
    {
        $this->config($model, $event);
        Artisan::call('make:event',['name' => $this->eventNamespace]);
    }

    protected function config($model, $event)
    {
        $event = ucfirst($event);
        if ($model) {
            $model = ucfirst($model);
            $this->eventNamespace
                = $this->getAppNamespace() . "$model\\Events\\$event";
        }
        else {
            $this->eventNamespace = $event;
        }
    }
}
