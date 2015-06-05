<?php namespace Tests\Generators;

use Tests\TestCase;
use Tests\Traits\InitializableTrait;
use Tests\Traits\MockableTrait;
use SKAgarwal\Reflection\ReflectableTrait;
use Illuminate\Filesystem\Filesystem;
use SKAgarwal\Generators\ModelGenerator;

class ModelGeneratorTest extends TestCase
{
    use MockableTrait, ReflectableTrait, InitializableTrait;

    /**
     * Initialization
     */
    protected function setUp()
    {
        $modelGenerator = $this->mock(
            ModelGenerator::class,
            [new Filesystem()],
            ['getAppNamespace'],
            ['App\\']
        );

        $this->reflect($modelGenerator);

        $this->callConfig('foo');
    }

    /**
     * @test
     */
    public function it_check_the_config()
    {
        $this->assertEquals('Foo', $this->getModel);
        $this->assertEquals('app/Foo', $this->getModelPath);
        $this->assertEquals('Foo/Foo', $this->getModelClassName);
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
    public function it_gets_the_migration_argument()
    {
        $migration = $this->callHasMigration(true);

        $this->assertEquals("--migration", $migration);
    }

    /**
     * @test
     */
    public function it_will_create_Model_directory()
    {
        $this->callMakeModelDirectory();
        $this->assertFileExists('app/Foo');
    }

    /**
     * @test
     */
    public function it_will_create_sub_directory()
    {
        $this->callMakeSubDirectory('Events');
        $this->assertFileExists('app/Foo/Events');
    }

    /**
     * @test
     */
    public function it_will_create_repository_contract()
    {
        $this->callMakeSubDirectory('Contracts');
        $this->callMakeRepositoryContract($this->getModelPath);
        $this->assertFileExists("{$this->getModelPath}/Contracts/{$this->getContractName}.php");
    }

    /**
     * @test
     */
    public function it_checks_repository_contracts_content()
    {
        $this->callMakeSubDirectory('Contracts');
        $this->callMakeRepositoryContract($this->getModelPath);
        $this->assertFileEquals(
            'stubs/FooRepository.stub',
            "{$this->getModelPath}/Contracts/{$this->getContractName}.php"
        );
    }

    /**
     * @test
     */
    public function it_will_create_repository()
    {
        $this->callMakeSubDirectory('Repositories');
        $this->callMakeEloquentRepository($this->getModelPath);
        $this->assertFileExists("{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php");
    }

    /**
     * @test
     */
    public function it_checks_eloquent_repositorys_content()
    {
        $this->callMakeSubDirectory('Repositories');
        $this->callMakeEloquentRepository($this->getModelPath);
        $this->assertFileEquals(
            'stubs/EloquentFooRepository.stub',
            "{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php"
        );
    }

    /**
     * Clean up stuff after tests.
     */
    protected function tearDown()
    {
        deleteFile("{$this->getModelPath}/Repositories/{$this->getRepositoryName}.php");
        deleteFile("{$this->getModelPath}/Contracts/{$this->getContractName}.php");

        deleteDir("{$this->getModelPath}/Events");
        deleteDir("{$this->getModelPath}/Repositories");
        deleteDir("{$this->getModelPath}/Contracts");
        deleteDir($this->getModelPath);
    }
}
