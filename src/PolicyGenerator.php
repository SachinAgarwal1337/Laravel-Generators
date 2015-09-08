<?php namespace SKAgarwal\Generators;

use Illuminate\Support\Facades\Artisan;
use SKAgarwal\Generators\Traits\PolicyGeneratableTrait;

class PolicyGenerator extends Generator
{
    use PolicyGeneratableTrait {
        config as policyConfig;
    }

    /**
     * Generate Policy.
     *
     * @param $name
     * @param $model
     */
    public function generate($name, $model)
    {
        $name = ucfirst($name);
        $this->config($model);

        Artisan::call('make:policy', [
            'name' => "{$this->policyNamespace}\\{$name}",
        ]);
    }

    /**
     * Configure Policy Generator.
     *
     * @param $model
     */
    protected function config($model)
    {
        parent::config($model);

        $this->policyConfig($this->model, $this->namespace);
    }
    
}
