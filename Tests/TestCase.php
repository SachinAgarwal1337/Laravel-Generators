<?php namespace Tests;

use PHPUnit_Framework_TestCase;

/**
 * Class TestCase
 *
 * @package Tests
 */
class TestCase extends PHPUnit_Framework_TestCase
{

    /**
     * Initialization.
     */
    public static function setUpBeforeClass()
    {
        mkdir('app');
        mkdir('stubs');
        $content = repository_interface_content();
        file_put_contents('stubs/FooRepository.stub', $content);

        $content = eloquent_repository_content();
        file_put_contents('stubs/EloquentFooRepository.stub', $content);
    }

    /**
     * Clean up Stuff After test.
     */
    public static function tearDownAfterClass()
    {
        rmdir('app');
        unlink('stubs/FooRepository.stub');
        unlink('stubs/EloquentFooRepository.stub');
        rmdir('stubs');
    }
}

/**
 * Generate content for repository interface.
 *
 * @return string
 */
function repository_interface_content()
{
    return <<<Contract
<?php namespace App\\Foo\\Contracts;

interface FooRepository
{

}

Contract;
}

/**
 * Generate content for Eloquent Repository.
 *
 * @return string
 */
function eloquent_repository_content()
{
    return <<<Repository
<?php namespace App\\Foo\\Repositories;

use App\\Foo\\Contracts\\FooRepository;

class EloquentFooRepository implements FooRepository
{

}

Repository;
}
