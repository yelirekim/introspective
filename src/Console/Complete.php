<?php

namespace Yelirekim\Introspective\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yelirekim\Introspective\Completer;

class Complete extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('introspective:complete')
            ->setDescription('Provide a list of strings suitable for completion in a text editor.')
            ->addOption(
                'format',
                null,
                InputOption::VALUE_REQUIRED,
                'Format for the suggestions, currently only \'atom\' is supported.',
                'atom'
            )
            ->addOption(
                'buffer',
                null,
                InputOption::VALUE_REQUIRED,
                'Contents of a text buffer to provide suggestions for.'
            )
            ->addOption(
                'row',
                null,
                InputOption::VALUE_REQUIRED,
                'Cursor row in the supplied buffer.'
            )
            ->addOption(
                'column',
                null,
                InputOption::VALUE_REQUIRED,
                'Cursor column in the supplied buffer.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(json_encode(Completer::suggest(
            $input->getOption('format'),
            $input->getOption('buffer'),
            $input->getOption('row'),
            $input->getOption('column')
        )));
    }
}
