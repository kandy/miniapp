<?php
use \Smil\ObjectManager as ObjectManager;

class HttpFrontController
{
    private $om;

    private $routing;

    public function __construct(ObjectManager $om, RouterRegex $router)
    {
        $this->om = $om;
        $this->routing = $router;
    }

    public function __invoke($context)
    {
        try {
            $class = $this->routing->match($context);
            //@todo: context switch decorator
            // router->match -> list of classes
            //
            return $this->om->get($class)->__invoke($_REQUEST);
        } catch (Exception $e) {
            return $e;
        }
    }
}