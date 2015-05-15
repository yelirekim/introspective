<?php

namespace Yelirekim\Introspective;

class Completer
{
    private $buffer;

    public function __construct(Provider\LiveBuffer $buffer)
    {
        $this->buffer = $buffer;
        $this->introspector = (new Introspector)
            ->addProvider($buffer)
            ->addProvider(new Provider\Reflect, 1);
    }

    public function suggestions($cursorRow, $cursorColumn)
    {
        
        $enclosing = $this->buffer->getEnclosingClassname($cursorRow, $cursorColumn);
        if($enclosing) {
            if($this->checkThisObjectOperator($cursorRow, $cursorColumn)) {
                return $this->introspector->getInternalObjectOperations($enclosing);
            }
        }
        return [];
    }

    private function checkPrecedingString($cursorRow, $cursorColumn, $string)
    {
        $stringLength = strlen($string);
        if($cursorColumn < $stringLength) {
            return false;
        }
        $row = $this->buffer->getRow($cursorRow);
        if($row === null) {
            return false;
        }
        $cursorIndex = $cursorColumn - 1;
        $preceding = substr($row, $cursorIndex - $stringLength, $stringLength);
        return $preceding == $string;
    }

    private function checkThisObjectOperator($cursorRow, $cursorColumn)
    {
        return $this->checkPrecedingString($cursorRow, $cursorColumn, '$this->');
    }

    public static function suggest($bufferContents, $cursorRow, $cursorColumn)
    {
        return (new Completer(new Provider\LiveBuffer($bufferContents)))
            ->suggestions($cursorRow, $cursorColumn);
    }
}
