<?php

namespace Yelirekim\Introspective\Util;

trait JsonSerializesPublicProperties
{
    public function jsonSerialize()
    {
        $rval = [];
        foreach((new \ReflectionClass($this))
            ->getProperties(\ReflectionProperty::IS_PUBLIC)
        as $property) {
            $name = $property->getName();
            if(isset($this->$name)) {
                $rval[$name] = $this->$name;
            }
        }
        return $rval;
    }
}
