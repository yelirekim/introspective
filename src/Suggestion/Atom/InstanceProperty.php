<?php

namespace Yelirekim\Introspective\Suggestion\Atom;

use Yelirekim\Introspective\Definition;

class InstanceProperty extends Suggestion
{
    public function __construct(Definition\Property $property)
    {
        $this->text = $property->name;
        $this->type = 'property';
    }
}
