<?php

namespace Tests\Generators;


use Tests\TestCase;
use SKAgarwal\Generators\PolicyGenerator;
use SKAgarwal\Reflection\ReflectableTrait;
use Tests\Traits\MockableTrait;

class PolicyGeneratorTest extends TestCase
{
    use MockableTrait, ReflectableTrait;

    protected function setUp()
    {
        $policyGenerator = $this->mock(
            PolicyGenerator::class,
            [],
            ['getAppNamespace'],
            ['App\\'],
            false
        );

        $this->reflect($policyGenerator);
    }

    /**
     * @test
     */
    public function it_configure_policy_generator()
    {
        $this->callConfig('foo');

        $this->assertEquals('Foo', $this->getModel);
        $this->assertEquals('App\\', $this->getNamespace);
        $this->assertEquals('App\\Foo\\Policies', $this->getPolicyNamespace);
    }
}
