<?php namespace Tests\Generators;

use SKAgarwal\Generators\ListenerGenerator;
use SKAgarwal\Reflection\ReflectableTrait;
use Tests\TestCase;
use Tests\Traits\MockableTrait;

class ListenerGeneratorTest extends TestCase
{
    use MockableTrait, ReflectableTrait;

    protected function setUp()
    {
        $listenerGenerator = $this->mock(
            ListenerGenerator::class,
            [],
            ['getAppNamespace'],
            ['App\\'],
            false
        );

        $this->reflect($listenerGenerator);
    }

    /**
     * @test
     */
    public function it_configure_listener_generator()
    {
        $this->setName = 'FooEventListener';
        $this->callConfig('foo');

        $this->assertEquals('Foo', $this->getModel);
        $this->assertEquals('App\\Foo\\Listeners', $this->getListenerNamespace);
        $this->assertEquals('App\\Foo\\Events', $this->getEventNamespace);
    }

    /**
     * @test
     */
    public function it_sets_name_argument_for_listener_command()
    {
        $this->setUpBeforeTests();

        $this->assertEquals(
            'App\\Foo\\Listeners\\FooEventListener',
            $this->getArguments['name']
        );

        $this->assertArrayNotHasKey('--event', $this->getArguments);
        $this->assertEmpty($this->getArguments['--queued']);
    }

    /**
     * @test
     */
    public function it_sets_name_event_arguments_for_listener_command()
    {
        $this->setUpBeforeTests(false, 'FooEvent');

        $this->assertEquals(
            'App\\Foo\\Listeners\\FooEventListener',
            $this->getArguments['name']
        );

        $this->assertArrayHasKey('--event', $this->getArguments);
        $this->assertEquals(
            'App\\Foo\\Events\\FooEvent',
            $this->getArguments['--event']
        );

        $this->assertEmpty($this->getArguments['--queued']);
    }

    /**
     * @tests
     */
    public function it_sets_name_queued_attributes_for_listener_command()
    {
        $this->setUpBeforeTests(true);

        $this->assertEquals(
            'App\\Foo\\Listeners\\FooEventListener',
            $this->getArguments['name']
        );

        $this->assertArrayNotHasKey('--event', $this->getArguments);
        $this->assertNotEmpty('--queued', $this->getArguments);
        $this->assertEquals('--queued', $this->getArguments['--queued']);
    }

    /**
     * @test
     */
    public function it_sets_name_queued_event_arguments_for_listener_command()
    {
        $this->setUpBeforeTests(true, 'FooEvent');

        $this->assertEquals(
            'App\\Foo\\Listeners\\FooEventListener',
            $this->getArguments['name']
        );

        $this->assertArrayHasKey('--event', $this->getArguments);
        $this->assertEquals(
            'App\\Foo\\Events\\FooEvent',
            $this->getArguments['--event']
        );

        $this->assertNotEmpty('--queued', $this->getArguments);
        $this->assertEquals('--queued', $this->getArguments['--queued']);
    }

    /**
     * Set up for required tests.
     *
     * @param bool $queued
     * @param null $event
     */
    private function setUpBeforeTests($queued = false, $event = null)
    {
        $this->setName = 'FooEventListener';
        $this->callConfig('foo');

        $options['queued'] = $queued;
        $options['event'] = $event;
        $this->callSetArguments($options);
    }
}
