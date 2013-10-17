<?php
namespace View;

class JsonViewModel
{
    public function __toString()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
}