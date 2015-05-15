<?php

namespace Yelirekim\Introspective\Suggestion;

use Yelirekim\Introspective\Definition;

abstract class Suggestor
{
    public function instanceOperation(Definition\Definition $definition)
    {
        if($definition instanceof Definition\Method) {
            return $this->instanceMethod($definition);
        } elseif($definition instanceof Definition\Property) {
            return $this->instanceProperty($definition);
        }

        throw new \InvalidArgumentException(sprintf(
            'instanceOperation expects either a Method or Property to be supplied, %s given',
            get_class($definition)));
    }

    abstract public function instanceProperty(Definition\Property $property);
    abstract public function instanceMethod(Definition\Method $method);

    public static function format($format)
    {
        if($format === 'atom') {
            return new Atom\Suggestor;
        } elseif($format === 'sublime') {
            return new Sublime\Suggestor;
        }

        throw new \UnexpectedValueException(sprintf(
            'No suggestor with format name %s found.',
            $format));
    }
}
