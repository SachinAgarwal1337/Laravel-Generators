<?php namespace Tests\Traits;

trait MockableTrait
{

    /**
     * A wraper for mocking the class and methods.
     *
     * @param       $originalClassName       Name of the class to mock.
     * @param array $constructorArguments    Parameters to pass to the original
     *                                       class' constructor.
     * @param array $methods                 When provided, only methods whose
     *                                       names are in the array are
     *                                       replaced
     *                                       with a configurable test double.
     *                                       The behavior of the other methods
     *                                       is not changed.
     * @param array $methodsReturnValues     Will be used as return values for
     *                                       the methods provided. Should be in
     *                                       the order of the methods provided
     *                                       in $methods array. If arguments
     *                                       are not needed for a particular
     *                                       method then provide 'null' for it.
     * @param bool  $callOriginalConstructor Can be used to disable the call to
     *                                       the original class' constructor.
     *
     * @return mock
     */
    public function mock(
        $originalClassName,
        $constructorArguments = [],
        $methods = [],
        $methodsReturnValues = [],
        $callOriginalConstructor = true
    ) {

        // Get the mock.
        $mock = $this->getMock($originalClassName, $methods,
            $constructorArguments, '',
            $callOriginalConstructor);

        return $this->stubMethods($methods, $methodsReturnValues, $mock);

    }

    /**
     * A wrapper for setting the stubs for the mocking methods.
     *
     * @param $methods
     * @param $methodArguments
     * @param $stub
     */
    private function stubMethods($methods, $methodsReturnValues, $stub)
    {
        foreach ($methods as $key => $method) {
            $stub->method($method)->willReturn($methodsReturnValues[$key]);
        }

        return $stub;
    }

}
