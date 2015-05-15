<?php

namespace Yelirekim\Introspective\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Complete extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('introspective:complete')
            ->setDescription('Provide a list of strings suitable for completion in a text editor.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
