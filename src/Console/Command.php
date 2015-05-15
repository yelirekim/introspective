<?php

namespace Yelirekim\Introspective\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this
            ->addOption(
               'bootstrap',
               null,
               InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
               'Path(s) to bootstrap file which should be included in order for '.
               'classes to be autoloadable or available while introspection occurs.'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        foreach($input->getOption('bootstrap') as $bootstrap) {
            if (!is_file($bootstrap) || !is_readable($bootstrap)) {
                throw new \Exception(sprintf(
                    'Bootstrap file %s does not exist or is not readable.',
                    $bootstrap));
            }
            require $bootstrap;
        }
    }
}
