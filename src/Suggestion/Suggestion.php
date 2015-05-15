<?php

namespace Yelirekim\Introspective\Suggestion;

use Yelirekim\Introspective\Util;

abstract class Suggestion implements \JsonSerializable
{
    use Util\JsonSerializesPublicProperties;
}
