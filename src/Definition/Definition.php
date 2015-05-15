<?php

namespace Yelirekim\Introspective\Definition;

abstract class Definition implements \JsonSerializable
{
    public $name = '';

    public function jsonSerialize()
    {
        $rval = [];
        foreach((new ReflectionClass($this))
            ->getProperties(ReflectionProperty::IS_PUBLIC)
        as $property) {
            $name = $property->getName();
            $rval[$name] = $this->$name;
        }
        return $rval;
    }
}
