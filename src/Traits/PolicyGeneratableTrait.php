<?php

namespace SKAgarwal\Generators\Traits;


trait PolicyGeneratableTrait
{
    /**
     * Namespace of the policy.
     *
     * @var string
     */
    protected $policyNamespace;

    /**
     * Set the namespace of the policy.
     *
     * @param string $policyNamespace
     *
     * @return $this
     */
    public function setPolicyNamespace($policyNamespace)
    {
        $this->policyNamespace = $policyNamespace;

        return $this;
    }

    /**
     * Set properties of Policy Generator.
     *
     * @param $model
     * @param $namespace
     */
    protected function config($model, $namespace)
    {
        $this->setPolicyNamespace("{$namespace}{$model}\\Policies");
    }

}
