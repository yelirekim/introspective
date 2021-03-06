<?php

namespace Yelirekim\Introspective\Provider;

abstract class Provider
{
    abstract public function getClass($classname);
    abstract public function hasClass($classname);

    protected function normalizeClassname($classname)
    {
        return ltrim($classname, '\\');
    }
}
