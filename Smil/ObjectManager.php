<?php
namespace Smil;

class ObjectManager
{

    private $pool;
    private $mapping;

    public function __construct()
    {
        $this->pool = new \StdClass();
        $this->pool->{'\Smil\ObjectManager'} = $this;
        $this->mapping = new \StdClass();
    }


    public function get($className)
    {
        if (!isset($this->pool->$className) && class_exists($className, true)) {
            $this->pool->$className = $this->create($className);
        }
        return $this->pool->$className;
    }

    public function create($className, array $arguments = array())
    {
        $constructArguments = $this->getConstructArguments($className, $arguments);
        $reflectionClass = new \ReflectionClass($className);
        return $reflectionClass->newInstanceArgs($constructArguments);
    }

    /**
     * Retrieve list of arguments that used for new object instance creation
     *
     * @param string $className
     * @param array $arguments
     * @return array
     */
    private function getConstructArguments($className, array $arguments = array())
    {
        $constructArguments = array();
        if (!method_exists($className, '__construct')) {
            return $constructArguments;
        }
        $method = new \ReflectionMethod($className, '__construct');

        foreach ($method->getParameters() as $parameter) {
            $parameterName = $parameter->getName();
            $argClassName = null;
            $defaultValue = null;

            if (isset($arguments[$parameterName])) {
                $constructArguments[$parameterName] = $arguments[$parameterName];
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $defaultValue = $parameter->getDefaultValue();
            }

            if ($parameter->getClass()) {
                $argClassName = $parameter->getClass()->getName();
            }

            $object = $this->get($argClassName);
            $constructArguments[$parameterName] = null === $object ? $defaultValue : $object;
        }
        return $constructArguments;
    }
}