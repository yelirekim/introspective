<?php

namespace Yelirekim\Introspective\Provider;

use Nette\Utils;

abstract class Provider
{
    abstract public function getClass($classname);
    abstract public function hasClass($classname);

    protected function normalizeClassname($classname)
    {
        if(!Utils\Strings::startsWith($classname, '\\')) {
            return '\\' . $classname;
        }

        return $classname;
    }
}
