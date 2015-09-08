<?php namespace SKAgarwal\Generators\Commands;

use Illuminate\Console\Command;
use SKAgarwal\Generators\PolicyGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PolicyGeneratorCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Model specific Policy class.';

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
     * @param EventGenerator $eventGen
     *
     * @return mixed
     */
    public function handle(PolicyGenerator $policyGen)
    {
        $name = $this->argument('name');
        $model = $this->option('model');
        $policyGen->generate($name, $model);

        $name = ucfirst($name);
        if ($model) {
            $model = ucfirst($model);
            $this->info("Created: app\\$model\\Policies\\$name.php");
        } else {
            $this->info("Created: app\\Policies\\$name.php");
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
                'name',
                InputArgument::REQUIRED,
                'Name of the policy class to be created.',
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
                '--model',
                '-m',
                InputOption::VALUE_REQUIRED,
                'Name of the model under which policy will be created.',
                null,
            ],
        ];
    }
}
