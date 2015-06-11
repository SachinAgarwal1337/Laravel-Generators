<?php namespace Tests\Generators;

use SKAgarwal\Generators\EventGenerator;
use SKAgarwal\Reflection\ReflectableTrait;
use Tests\TestCase;
use Tests\Traits\MockableTrait;

class EventGeneratorTest extends TestCase
{

    use MockableTrait, ReflectableTrait;

    /**
     * Setup Before all the tests
     */
    protected function setUp()
    {
        $eventGenerator = $this->mock(
            EventGenerator::class,
            [],
            ['getAppNamespace'],
            ['App\\'],
            false
        );

        $this->reflect($eventGenerator);
    }

    /**
     * @test
     * @covers SKAgarwal\Generators\EventGenerator::generate
     */
    public function it_will_configure_event_generator()
    {
        $this->callConfig('foo');
        $this->assertEquals('Foo', $this->getModel);
        $this->assertEquals('App\\Foo\\Events', $this->getEventNamespace);
    }
}
