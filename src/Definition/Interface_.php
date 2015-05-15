<?php

namespace Yelirekim\Introspective\Definition;

class Interface_ extends Definition
{
    use HasInterface, HasNamespace;

    public $extends = [];
}
