<?php namespace SKAgarwal\Generators\Traits;

trait EventGeneratableTrait
{

    /**
     * Namespace of the event.
     *
     * @var string
     */
    protected $eventNamespace;

    /**
     * Set the namespace of the event.
     *
     * @param string $eventNamespace
     *
     * @return $this
     */
    public function setEventNamespace($eventNamespace)
    {
        $this->eventNamespace = $eventNamespace;

        return $this;
    }

    /**
     * Set properties of Event Generator.
     *
     * @param $model
     * @param $namespace
     */
    protected function config($model, $namespace)
    {
        $this->setEventNamespace("{$namespace}{$model}\\Events");
    }

}
