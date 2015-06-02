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
        $this->registerEventGenerator();
        $this->registerListenerGenerator();
    }

    /**
     * register create:model command
     */
    private function registerModelGenerator()
    {
        $this->app->singleton('command.skagarwal.model', function ($app) {
            return $app['SKAgarwal\Generators\Commands\ModelGeneratorCommand'];
        });
        $this->commands('command.skagarwal.model');
    }

    /**
     * register create:repository command
     */
    private function registerRepositoryGenerator()
    {
        $this->app->singleton('command.skagarwal.repository', function ($app) {
            return $app['SKAgarwal\Generators\Commands\RepositoryGeneratorCommand'];
        });
        $this->commands('command.skagarwal.repository');
    }

    /**
     * register create:evetn command
     */
    private function registerEventGenerator()
    {
        $this->app->singleton('command.skagarwal.event', function ($app) {
            return $app['SKAgarwal\Generators\Commands\EventGeneratorCommand'];
        });
        $this->commands('command.skagarwal.event');
    }

    /**
     * register create:listener command
     */
    private function registerListenerGenerator()
    {
        $this->app->singleton('command.skagarwal.listener', function ($app) {
            return $app['SKAgarwal\Generators\Commands\ListenerGeneratorCommand'];
        });
        $this->commands('command.skagarwal.listener');
    }
}
