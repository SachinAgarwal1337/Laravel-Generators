<?php namespace SKAgarwal\Generators\Commands;

use SKAgarwal\Generators\GenerateClasses;
use Illuminate\Console\Command;

class ModelGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model:structure {model} {--migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Directory structure for a model';

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
     * @param GenerateClasses $class
     *
     * @return mixed
     */
    public function handle(GenerateClasses $class)
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

    public static function instance()
    {
        return new static();
    }
}
