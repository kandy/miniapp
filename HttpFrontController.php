<?php
use \Smil\ObjectManager as ObjectManager;

class HttpFrontController
{
    private $om;
    private $routing;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->routing = [
            '/' => '\Query\HomeQuery',
            'rest' => 'Rest',
            'soap' => 'Soap'

        ];
    }

    public function __invoke($context)
    {
        try {
            $class = $this->routing[dirname($context['REQUEST_URI'])]; //@todo: RoutingLevelOne
            //@todo: context switch decorator
            // router->match -> list of classes
            //
            return $this->om->get($class)->__invoke($_REQUEST);
        } catch (Exception $e) {
            return $e;
        }
    }
}