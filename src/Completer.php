<?php

namespace Yelirekim\Introspective;

class Completer
{
    private $buffer;

    public function __construct(Parser\LiveBuffer $buffer)
    {
        $this->buffer = $buffer;
    }

    public function suggestions($cursorRow, $cursorColumn)
    {
        return [];
    }

    public static function complete($bufferContents, $cursorRow, $cursorColumn)
    {
        return (new Completer(new Parser\LiveBuffer($bufferContents)))
            ->suggestions($cursorRow, $cursorColumn);
    }
}
