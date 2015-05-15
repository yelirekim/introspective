<?php

namespace Yelirekim\Introspective;

class Completer
{
    private $buffer;
    private $suggestor;

    public function __construct(Provider\LiveBuffer $buffer, Suggestion\Suggestor $suggestor)
    {
        $this->buffer = $buffer;
        $this->introspector = (new Introspector)
            ->addProvider($buffer)
            ->addProvider(new Provider\Reflect, 1);
        $this->suggestor = $suggestor;
    }

    public function suggestions($cursorRow, $cursorColumn)
    {
        $suggestions = [];
        $enclosing = $this->buffer->getEnclosingClassname($cursorRow, $cursorColumn);
        if($enclosing) {
            if($this->checkThisObjectOperator($cursorRow, $cursorColumn)) {
                $operations = $this->introspector->getInternalObjectOperations($enclosing);
                foreach ($operations as $operation) {
                    $suggestions[] = $this->suggestor->instanceOperation($operation);
                }
            }
        }
        return $suggestions;
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

    public static function suggest($format, $bufferContents, $cursorRow, $cursorColumn)
    {
        return (new Completer(new Provider\LiveBuffer($bufferContents), Suggestion\Suggestor::format($format)))
            ->suggestions($cursorRow, $cursorColumn);
    }
}
