<?php namespace SKagarwal\Generators\Commands;

use Illuminate\Console\Command;
use SKAgarwal\Generators\JobGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class JobGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
    public function handle(JobGenerator $jobGenerator)
    {
        $name = $this->argument('name');
        $options['model'] = $this->option('model');
        $options['queued'] = $this->option('queued');

        $jobGenerator->generate($name, $options);

        $name = ucfirst($name);
        $model = ucfirst($options['model']);
        $this->info("Created: app\\{$model}\\Jobs\\{$name}");
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
                'Name of the event listener class.'
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
                'Name of the model under which job will be created.',
                null
            ],
            [
                '--queued',
                '-e',
                InputOption::VALUE_NONE,
                'Indicated that Job should be queued.',
                null
            ],
        ];
    }
}
