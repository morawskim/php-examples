<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FooAppCommand extends Command
{
    protected static $defaultName = 'app:foo';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Foo command!');

        return Command::SUCCESS;
    }
}
