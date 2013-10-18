<?php
interface Router
{
    public function match(array $context);
}

class RouterRegex implements  Router
{
    public function  __construct()
    {

        $this->routing = [
            'base' => [
                'regex' => '#^/index#i',
                'class' => '\Query\HomeQuery',
            ],
        ];
    }

    public function match(array $context)
    {

        foreach ($this->routing as $name => $val)
        {

            if (false !== preg_match($val['regex'], $context['REQUEST_URI']) )
            {
                return $val['class'];
            }
        }

    }
}