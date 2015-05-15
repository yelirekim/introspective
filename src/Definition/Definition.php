<?php

namespace Yelirekim\Introspective\Definition;

use Closure;

abstract class Definition implements \JsonSerializable
{
    public $name = '';

    public function jsonSerialize()
    {
        $rval = [];
        foreach((new \ReflectionClass($this))
            ->getProperties(\ReflectionProperty::IS_PUBLIC)
        as $property) {
            $name = $property->getName();
            $rval[$name] = $this->$name;
        }
        return $rval;
    }

    public function filterProperty($name, Closure $callback)
    {
        $filtered = [];
        foreach($this->$name as $definition) {
            if($callback($definition, $this)) {
                $filtered[] = $definition;
            }
        }
        return $filtered;
    }
}
