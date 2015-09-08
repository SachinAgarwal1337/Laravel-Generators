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
        $this->registerJobGenerator();
        $this->registerPolicyGenerator();
    }

    /**
     * Register the create:model command.
     */
    private function registerModelGenerator()
    {
        $this->app->singleton('command.skagarwal.model', function ($app) {
            return $app['SKAgarwal\Generators\Commands\ModelGeneratorCommand'];
        });

        $this->commands('command.skagarwal.model');
    }

    /**
     * Register the create:repository command.
     */
    private function registerRepositoryGenerator()
    {
        $this->app->singleton('command.skagarwal.repository', function ($app) {
            return $app['SKAgarwal\Generators\Commands\RepositoryGeneratorCommand'];
        });

        $this->commands('command.skagarwal.repository');
    }

    /**
     * Register the create:event command.
     */
    private function registerEventGenerator()
    {
        $this->app->singleton('command.skagarwal.event', function ($app) {
            return $app['SKAgarwal\Generators\Commands\EventGeneratorCommand'];
        });

        $this->commands('command.skagarwal.event');
    }

    /**
     * Register the create:listener command.
     */
    private function registerListenerGenerator()
    {
        $this->app->singleton('command.skagarwal.listener', function ($app) {
            return $app['SKAgarwal\Generators\Commands\ListenerGeneratorCommand'];
        });

        $this->commands('command.skagarwal.listener');
    }

    /**
     * Register the create:job command.
     */
    private function registerJobGenerator()
    {
        $this->app->singleton('command.skagarwal.job', function ($app) {
            return $app['SKAgarwal\Generators\Commands\JobGeneratorCommand'];
        });

        $this->commands('command.skagarwal.job');
    }

    /**
     * Register the create:job command.
     */
    private function registerPolicyGenerator()
    {
        $this->app->singleton('command.skagarwal.policy', function ($app) {
            return $app['SKAgarwal\Generators\Commands\PolicyGeneratorCommand'];
        });

        $this->commands('command.skagarwal.policy');
    }
}
