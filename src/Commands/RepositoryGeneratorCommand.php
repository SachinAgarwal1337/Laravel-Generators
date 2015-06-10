<?php namespace SKAgarwal\Generators\Commands;

use Illuminate\Console\Command;
use SKAgarwal\Generators\RepositoryGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RepositoryGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Repository Contract and its Eloquent Repository Implimentation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(RepositoryGenerator $repoGenreator)
    {
        $model = ucfirst($this->argument('model'));
        $repo = $this->option('repository');
        $repoGenreator->generate($model, $repo);

        $repo = ucfirst($repo ?: $model);
        $this->info("Created: app\\{$model}\\Contracts\\{$repo}Repository");
        $this->info("Created: app\\{$model}\\Repositories\\Eloquent{$repo}Repository");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'model',
                InputArgument::REQUIRED,
                'Name of the model to be created.'
            ],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                '--repository',
                '-r',
                InputOption::VALUE_REQUIRED,
                'Name of the repository to be created.',
                null
            ],
        ];
    }
}
