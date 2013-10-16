<?php
namespace Query;

class HomeQuery
{
    //
    private $vmFactory;

    public function __construct(\View\JsonViewModelFactory $vmFactory)
    {
        $this->vmFactory = $vmFactory;
    }

    public function __invoke($context)
    {
        $vm = $this->vmFactory->create();
        $vm->message = ['Hello ', 'world'];
        return $vm;
    }
}