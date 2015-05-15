<?php

namespace Yelirekim\Introspective\Definition;

use Closure;
use Yelirekim\Introspective\Util;

abstract class Definition implements \JsonSerializable
{
    use Util\JsonSerializesPublicProperties;

    public $name = '';

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
