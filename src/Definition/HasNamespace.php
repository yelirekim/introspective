<?php

namespace Yelirekim\Introspective\Definition;

trait HasNamespace
{
    public $namespace = '';

    public function getNamespacedName()
    {
        return $this->namespace . '\\' . $this->name;
    }
}
