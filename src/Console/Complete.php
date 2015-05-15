<?php

namespace Yelirekim\Introspective\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yelirekim\Introspective\Provider\LiveBuffer;

class Complete extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('introspective:complete')
            ->setDescription('Provide a list of strings suitable for completion in a text editor.')
            ->addOption(
               'buffer',
               null,
               InputOption::VALUE_REQUIRED,
               'Contents of a text buffer to provide suggestions for.'
            )
            ->addArgument(
                'cursor-row',
                InputArgument::REQUIRED,
                'Cursor row in the supplied buffer.'
            )
            ->addArgument(
                'cursor-column',
                InputArgument::REQUIRED,
                'Cursor column in the supplied buffer.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $buffer = new LiveBuffer($input->getOption('buffer'));
    }
}
