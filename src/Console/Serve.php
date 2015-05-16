<?php

namespace Yelirekim\Introspective\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Serve extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('introspective:serve')
            ->setDescription('Run an HTTP server providing completion suggestions.')
            ->addOption(
                'address',
                'addr',
                InputArgument::OPTIONAL,
                'The hostname or IP to serve from.',
                'localhost'
            )
            ->addOption(
                'port',
                null,
                InputArgument::OPTIONAL,
                'The port to serve on.',
                8080
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        passthru(sprintf('bootstrap=%s %s -d variables_order=EGPCS -S %s:%s %s',
            escapeshellarg(json_encode($input->getOption('bootstrap'))),
            PHP_BINARY,
            $input->getOption('address'),
            $input->getOption('port'),
            dirname(dirname(dirname(__FILE__))).'/web/index.php'));
    }
}
