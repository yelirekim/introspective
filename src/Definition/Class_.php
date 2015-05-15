<?php

namespace Yelirekim\Introspective\Definition;

class Class_ extends Definition
{
    use HasInterface, HasNamespace;

    public $properties = [];
    public $extends = null;
}
