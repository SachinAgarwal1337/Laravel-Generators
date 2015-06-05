<?php namespace Tests\Traits;

trait InitializableTrait
{
    /**
     * Initialization before all tests.
     */
    public static function setUpBeforeClass()
    {
        mkdir('app');
        mkdir('stubs');
        $content = repository_interface_content('Foo');
        file_put_contents('stubs/FooRepository.stub', $content);

        $content = eloquent_repository_content('Foo');
        file_put_contents('stubs/EloquentFooRepository.stub', $content);
    }

    /**
     * Clean up Stuff After all tests.
     */
    public static function tearDownAfterClass()
    {
        rmdir('app');
        unlink('stubs/FooRepository.stub');
        unlink('stubs/EloquentFooRepository.stub');
        rmdir('stubs');
    }
}
