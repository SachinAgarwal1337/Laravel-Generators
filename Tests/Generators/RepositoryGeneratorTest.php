<?php namespace Tests\Generators;

use Illuminate\Filesystem\Filesystem;
use SKAgarwal\Generators\RepositoryGenerator;
use SKAgarwal\Reflection\ReflectableTrait;
use Tests\TestCase;
use Tests\Traits\InitializableTrait;
use Tests\Traits\MockableTrait;

class RepositoryGeneratorTest extends TestCase
{
    use MockableTrait, ReflectableTrait, InitializableTrait;

    /**
     * Initialization.
     */
    public static function setUpBeforeClass()
    {
        InitializableTrait::setUpBeforeClass();

        $content = repository_interface_content('Bar');
        file_put_contents('stubs/BarRepository.stub', $content);

        $content = eloquent_repository_content('Bar');
        file_put_contents('stubs/EloquentBarRepository.stub', $content);
    }

    /**
     * Initialization
     */
    protected function setUp()
    {
        $repoGenerator = $this->mock(RepositoryGenerator::class,
            [new Filesystem()],
            ['getAppNamespace'],
            ['App\\']
        );

        $this->reflect($repoGenerator);
    }

    /**
     * @test
     */
    public function it_sets_the_config()
    {
        $this->callConfig('foo');

        $this->assertEquals('Foo', $this->getModel);
        $this->assertEquals('app/Foo', $this->getModelPath);
        $this->assertEquals('FooRepository', $this->getContractName);
        $this->assertEquals('EloquentFooRepository', $this->getRepositoryName);
        $this->assertEquals('App\\Foo\\Contracts', $this->getContractNamespace);
        $this->assertEquals(
            'App\\Foo\\Repositories',
            $this->getRepositoryNamespace
        );
    }

    /**
     * @test
     */
    public function it_creates_contract_and_repository_for_given_model()
    {
        $this->callGenerate('foo', null);

        $this->assertFileExists("{$this->getModelPath}/Contracts/{$this->getContractName}.php");
        $this->assertFileEquals(
            'stubs/FooRepository.stub',
            "{$this->getModelPath}/Contracts/{$this->getContractName}.php"
        );

        $this->assertFileExists("{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php");
        $this->assertFileEquals(
            'stubs/EloquentFooRepository.stub',
            "{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php"
        );

    }

    /**
     * @test
     */
    public function it_creates_contract_and_repository_for_repository_name()
    {
        $this->callGenerate('foo', 'bar');

        $this->assertFileExists("{$this->getModelPath}/Contracts/{$this->getContractName}.php");
        $this->assertFileEquals(
            'stubs/BarRepository.stub',
            "{$this->getModelPath}/Contracts/{$this->getContractName}.php"
        );

        $this->assertFileExists("{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php");
        $this->assertFileEquals(
            'stubs/EloquentBarRepository.stub',
            "{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php"
        );

    }

    /**
     * Clean up stuff after each tests.
     */
    protected function tearDown()
    {
        deleteFile("{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php");
        deleteFile("{$this->getModelPath}/Contracts/{$this->getContractName}.php");

        deleteDir("{$this->getModelPath}/Repositories");
        deleteDir("{$this->getModelPath}/Contracts");
        deleteDir($this->getModelPath);
    }

    /**
     * Clean up Stuff After all tests.
     */
    public static function tearDownAfterClass()
    {
        unlink('stubs/BarRepository.stub');
        unlink('stubs/EloquentBarRepository.stub');
        InitializableTrait::tearDownAfterClass();
    }
}
