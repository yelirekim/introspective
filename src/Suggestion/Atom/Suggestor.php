<?php

namespace Yelirekim\Introspective\Suggestion\Atom;

use Yelirekim\Introspective\Definition;

class Suggestor extends \Yelirekim\Introspective\Suggestion\Suggestor
{
    public function instanceProperty(Definition\Property $property)
    {
        return new InstanceProperty($property);
    }

    public function instanceMethod(Definition\Method $method)
    {
        return new InstanceMethod($method);
    }
}
