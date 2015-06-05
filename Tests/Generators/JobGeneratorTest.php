<?php namespace Tests\Generators;

use SKAgarwal\Generators\JobGenerator;
use SKAgarwal\Reflection\ReflectableTrait;
use Tests\TestCase;
use Tests\Traits\MockableTrait;

class JobGeneratorTest extends TestCase
{
    use MockableTrait, ReflectableTrait;

    protected function setUp()
    {
        $jobGenerator = $this->mock(
            JobGenerator::class,
            [],
            ['getAppNamespace'],
            ['App\\'],
            false
        );

        $this->reflect($jobGenerator);
    }

    /**
     * @test
     */
    public function it_configure_job_generator()
    {
        $this->callConfig('foo');

        $this->assertEquals('Foo', $this->getModel);
        $this->assertEquals('App\\', $this->getNamespace);
        $this->assertEquals('App\\Foo\\Jobs', $this->getJobNamespace);
    }

    /**
     * @test
     */
    public function it_checks_if_job_is_queued()
    {
        $queued = $this->callIsQueued(true);

        $this->assertEquals('--queued', $queued);
    }

    /**
     * @test
     */
    public function it_checks_if_job_is_not_queued()
    {
        $queued = $this->callIsQueued(false);

        $this->assertEmpty($queued);
    }
}
