<?php

namespace Yelirekim\Introspective\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yelirekim\Introspective\Introspector;

class Introspect extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('introspective:introspect')
            ->setDescription('Get an exhaustive specification of the properties of a given class.')
            ->addArgument(
                'classname',
                InputArgument::REQUIRED,
                'The full name of the class to be inspected.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(json_encode(Introspector::reflect($input->getArgument('classname'))));
    }
}
