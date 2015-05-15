<?php

namespace Yelirekim\Introspective\Definition;

class Method extends Definition
{
    use HasVisibility;

    public $returnType = null;
    public $parameters = [];
}
