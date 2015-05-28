<?php namespace SKAgarwal\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModelGenerator();
    }

    /**
     * register make:model:structure command
     */
    private function registerModelGenerator()
    {
        $this->app->singleton('command.skagarwal.model', function ($app) {
            return $app['SKAgarwal\Generators\Commands\ModelGeneratorCommand'];
        });
        $this->commands('command.skagarwal.model');
    }
}
