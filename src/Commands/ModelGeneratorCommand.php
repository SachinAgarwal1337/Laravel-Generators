<?php namespace SKAgarwal\Generators\Commands;

use SKAgarwal\Generators\ModelGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModelGeneratorCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate directory structure for a Model.';

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
     * @param ModelGenerator $class
     *
     * @return mixed
     */
    public function handle(ModelGenerator $class)
    {
        $model = ucfirst($this->argument('model'));
        $migration = $this->option('migration');
        $class->generate($model, $migration);

        $this->info('Created Following Structure:');
        $this->info("{$model}/");
        $this->info("  |");
        $this->info("  |_{$model}.php");
        $this->info("  |");
        $this->info("  |_Contracts/");
        $this->info("    |");
        $this->info("    |_{$model}Repository.php");
        $this->info("  |");
        $this->info("  |_Events/");
        $this->info("  |");
        $this->info("  |_Policies/");
        $this->info("  |");
        $this->info("  |_Jobs/");
        $this->info("  |");
        $this->info("  |_Listeners/");
        $this->info("  |");
        $this->info("  |_Repositories/");
        $this->info("    |");
        $this->info("    |_Eloquent{$model}Repository.php");

        if ($migration) {
            $this->info("\n Migration for {$model} created");
        }
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
                '--migration',
                '-m',
                InputOption::VALUE_NONE,
                'Create a migration file for the model',
                null
            ],
        ];
    }
}
