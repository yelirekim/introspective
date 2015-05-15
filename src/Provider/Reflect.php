<?php

namespace Yelirekim\Introspective\Provider;

use Yelirekim\Introspective\Definition;

class Reflect extends Provider
{
    public function getClass($classname)
    {
        if($class = $this->reflectClass($classname)) {
            return (new Definition\Hydrator\ReflectionHydrator)->class_($class);
        }

        return null;
    }

    public function hasClass($classname)
    {
        return $this->reflectClass($classname) !== null;
    }

    private function reflectClass($classname)
    {
        try {
            return new \ReflectionClass($classname);
        } catch (Exception $e) {
        }
        return null;
    }
}
