<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BarAppCommand extends Command
{
    protected static $defaultName = 'app:bar';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Bar command!');

        return Command::SUCCESS;
    }
}
