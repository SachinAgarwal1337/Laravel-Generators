<?php namespace SKAgarwal\Generators\Traits;

trait ListenerGeneratableTrait
{
    /**
     * @var string
     */
    protected $listenerNamespace;

    /**
     * @param string $eventNamespace
     *
     * @return $this
     */
    protected function setListenerNamespace($listenerNamespace)
    {
        $this->listenerNamespace = $listenerNamespace;

        return $this;
    }

    /**
     * Set the properties for the Event Listener
     *
     * @param $model
     * @param $namespace
     */
    protected function config($model, $namespace)
    {
        $this->setListenerNamespace("{$namespace}{$model}\\Listeners");
    }
}
