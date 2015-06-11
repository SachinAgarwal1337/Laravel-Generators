<?php namespace SKAgarwal\Generators\Commands;

use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Console\Command;
use SKAgarwal\Generators\ListenerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ListenerGeneratorCommand extends Command
{

    use AppNamespaceDetectorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Model specific Listener class.';

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
     * @param ListenerGenerator $listenerGenerator
     *
     * @return mixed
     */
    public function handle(ListenerGenerator $listenerGenerator)
    {
        $name = $this->argument('name');
        $options['model'] = $this->option('model');
        $options['event'] = $this->option('event');
        $options['queued'] = $this->option('queued');

        $listenerGenerator->generate($name, $options);
        $listener = ucfirst($name);
        if ($options['model']) {
            $model = ucfirst($options['model']);
            $this->info("Created: app\\{$model}\\Listeners\\{$listener}.php");
        } else {
            $this->info("Created: app\\Listeners\\{$listener}.php");
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
                'Name of the model under which event will be created.',
                null
            ],
            [
                '--event',
                '-e',
                InputOption::VALUE_REQUIRED,
                'The event class, the listener is being listened for',
                null
            ],
            [
                '--queued',
                null,
                InputOption::VALUE_NONE,
                'Indicates event listener should be queued',
                null
            ],
        ];
    }
}
