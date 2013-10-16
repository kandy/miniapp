<?php
namespace Smil\ObjectManager;

trait Factory
{
    /**
     * @var \Smil\ObjectManager
     */
    private $om;

    public function __construct(\Smil\ObjectManager $om)
    {
        $this->om = $om;
    }

    public function create($data = array())
    {
        return $this->om->create(static::CLASS_NAME, $data);
    }
}