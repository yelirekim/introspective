<?php

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

use Yelirekim\Introspective\Console\Complete;
use Yelirekim\Introspective\Console\Web;
use Symfony\Component\Console;

$buffer = new Web\ServeOutput;
$logger = new Console\Logger\ConsoleLogger(new Console\Output\ConsoleOutput);

(new Complete(null, $logger))
    ->run(new Web\ServeInput, $buffer);

echo $buffer->fetch();
