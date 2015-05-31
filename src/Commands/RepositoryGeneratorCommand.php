<?php namespace SKAgarwal\Generators\Commands;

use Illuminate\Console\Command;
use SKAgarwal\Generators\RepositoryGenerator;

class RepositoryGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model} {--repo=}';

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
        $repo = $this->option('repo');
        $repoGenreator->generate($model, $repo);

        $repo = ucfirst($repo ?: $model);
        $this->info("{$model}\\Contracts\\{$repo}Repository Created");
        $this->info("{$model}\\Repositories\\Eloquent{$repo}Repository Created");
    }
}
