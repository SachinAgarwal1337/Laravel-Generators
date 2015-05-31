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
        $this->registerRepositoryGenerator();
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

    /**
     * register make:repository command
     */
    private function registerRepositoryGenerator()
    {
        $this->app->singleton('command.skagarwal.repository', function ($app) {
            return $app['SKAgarwal\Generators\Commands\RepositoryGeneratorCommand'];
        });
        $this->commands('command.skagarwal.repository');
    }
}
