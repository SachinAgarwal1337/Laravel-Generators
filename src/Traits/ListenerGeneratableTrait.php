<?php namespace SKAgarwal\Generators\Traits;

trait ListenerGeneratableTrait
{
    /**
     * Namespace of the listener.
     *
     * @var string
     */
    protected $listenerNamespace;

    /**
     * Set the listener namespace.
     *
     * @param string $listenerNamespace
     *
     * @return $this
     */
    protected function setListenerNamespace($listenerNamespace)
    {
        $this->listenerNamespace = $listenerNamespace;

        return $this;
    }

    /**
     * Set the properties for the Event Listener.
     *
     * @param $model
     * @param $namespace
     */
    protected function config($model, $namespace)
    {
        $this->setListenerNamespace("{$namespace}{$model}\\Listeners");
    }
}
