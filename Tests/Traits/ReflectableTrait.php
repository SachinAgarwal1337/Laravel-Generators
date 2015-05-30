<?php namespace Tests\Traits;

use ReflectionClass;
use Tests\Exceptions\MethodNotFoundException;
use Tests\Exceptions\ObjectNotFoundException;

/**
 * For easy testing of protected methods
 *
 * trait ReflectableTrait
 *
 * @package Tests\Traits
 */
trait ReflectableTrait
{
    /**
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Object of the class to be reflected.
     *
     * @var
     */
    protected $classObj;

    /**
     * check if the method is been called.
     *
     * @param $method
     *
     * @return int
     */
    private function isCallMethod($method)
    {
        return preg_match('/^call/', $method);
    }

    /**
     * Extract the dynamic method name.
     *
     * @param $method
     *
     * @return string
     */
    private function extractMethodName($method)
    {
        return lcfirst(preg_replace('/call/', '', $method, 1));
    }

    /**
     * Check if Property is been accessed.
     *
     * @param $name
     *
     * @return int
     */
    private function isGetProperty($name)
    {
        return preg_match('/^get/', $name);
    }

    /**
     * Extract the dynamic property name.
     *
     * @param $name
     *
     * @return mixed
     */
    private function extractPropertyName($name)
    {
        return lcfirst(preg_replace('/get/', '', $name, 1));
    }

    /**
     * $classObj and $reflection properties should be defined.
     *
     * @throws ObjectNotFoundException
     */
    private function checkClassObjAndReflectionProperties()
    {
        if (!$this->classObj || !$this->reflection) {
            throw new ObjectNotFoundException("Should be called after 'on()' method.");
        }
    }

    /**
     * check if property or method
     * is private or protected.
     *
     * @param $object ReflectionMethod / ReflectionProperty
     *
     * @return bool
     */
    private function setAccessibleOn($object)
    {
        if ($object->isPrivate() || $object->isProtected()) {
            $object->setAccessible(true);
        }
    }

    /**
     * Getting the reflection.
     *
     * @param $classObj Object of the class the reflection to be created.
     */
    public function reflect($classObj)
    {
        if (! $this->classObj) {
            $this->classObj = $classObj;
        }

        if (! $this->reflection) {
            $this->reflection = new ReflectionClass($classObj);
        }
    }

    /**
     * Getting the reflection.
     *
     * @param $classObj Object of the class the reflection to be created.
     *
     * @return $this
     */
    public function on($classObj)
    {
        $this->reflect($classObj);

        return $this;
    }

    /**
     * Call to public/private/protected methods.
     *
     * @param       $method    Method name to be called (case sensitive)
     * @param array $arguments Arguments to be passed to the method
     *
     * @return $this
     * @throws ObjectNotFoundException
     */
    public function call($method, $arguments = [])
    {
        $this->checkClassObjAndReflectionProperties();

        $method = $this->reflection->getMethod($method);
        $this->setAccessibleOn($method);
        $method->invokeArgs($this->classObj, $arguments);

        return $this;
    }

    /**
     * Get value of public/private/protected properties.
     *
     * @param $name Property name to be accessed (Case sensitive).
     *
     * @return mixed
     */
    public function get($name)
    {
        $property = $this->reflection->getProperty($name);
        $this->setAccessibleOn($property);

        return $property->getValue($this->classObj);
    }

    /**
     * @param       $method
     * @param array $arguments
     *
     * @return ReflectableTrait
     * @throws MethodNotFoundException
     * @throws ObjectNotFoundException
     */
    public function __call($method, $arguments = [])
    {
        if ($this->isCallMethod($method)) {
            $methodName = $this->extractMethodName($method);

            return $this->call($methodName, $arguments);
        }

        throw new MethodNotFoundException("Method '{$method}' is not defined.");
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->isGetProperty($name)) {
            $name = $this->extractPropertyName($name);

            return $this->get($name);
        }
    }
}
