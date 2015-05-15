<?php

namespace Yelirekim\Introspective\Definition;

class Class_ extends Definition
{
    use HasInterface;

    public $properties = [];
    public $extends = null;
}
