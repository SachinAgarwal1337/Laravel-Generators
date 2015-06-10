<?php namespace SKAgarwal\Generators\Traits;

trait JobGeneratableTrait
{

    /**
     * @var
     */
    protected $jobNamespace;

    /**
     * @param mixed $jobNamespace
     *
     * @return $this
     */
    public function setJobNamespace($jobNamespace)
    {
        $this->jobNamespace = $jobNamespace;

        return $this;
    }

    /**
     * Set the properties for the Job
     *
     * @param $model
     * @param $namespace
     */
    protected function config($model, $namespace)
    {
        $this->setJobNamespace("{$namespace}{$model}\\Jobs");
    }
}
