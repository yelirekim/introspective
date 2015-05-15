<?php

namespace Yelirekim\Introspective\Suggestion\Atom;

use Yelirekim\Introspective\Definition;

class InstanceMethod extends Suggestion
{
    public function __construct(Definition\Method $method)
    {
        $this->snippet = $this->buildSnippet($method);
        $this->displayText = $method->name;
        $this->type = 'method';
    }

    protected function buildSnippet(Definition\Method $method)
    {
        $parameterNames = [];
        foreach ($method->parameters as $parameter) {
            $parameterNames[] = $parameter->name;
        }
        return $method->name.'('.implode(', ', Snippet::args($parameterNames)).')';
    }
}
