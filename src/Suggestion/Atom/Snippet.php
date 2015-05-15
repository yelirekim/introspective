<?php

namespace Yelirekim\Introspective\Suggestion\Atom;

class Snippet
{
    private $index;
    private $name;

    public function __construct($index, $name)
    {
        $this->index = $index;
        $this->name = $name;
    }

    public function __toString()
    {
        return '${'.$this->index.':'.$this->name.'}';
    }

    public static function arg($index, $name)
    {
        return new Snippet($index, $name);
    }

    public static function args(array $names)
    {
        $args = [];
        foreach ($names as $index => $name) {
            $args[] = Snippet::arg($index + 1, $name);
        }
        return $args;
    }
}
