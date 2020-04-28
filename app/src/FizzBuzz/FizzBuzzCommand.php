<?php

declare(strict_types=1);

namespace App\FizzBuzz;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FizzBuzzCommand extends Command
{
    private const ARGUMENT_FIRST = 'first';
    private const ARGUMENT_LAST = 'last';

    protected function configure()
    {
        $this
            ->setName('exads:challenge:fizzbuzz')
            ->setDescription('Execute Fizz Buzz script')
            ->addUsage('exads:challenge:fizzbuzz 100')
            ->addArgument(self::ARGUMENT_LAST, InputArgument::OPTIONAL, 'Last value', 100)
            ->addArgument(self::ARGUMENT_FIRST, InputArgument::OPTIONAL, 'First value', 1)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fizzBuzz = new FizzBuzz(
            (int) $input->getArgument(self::ARGUMENT_FIRST),
            (int) $input->getArgument(self::ARGUMENT_LAST)
        );

        //Improve output
        dump($fizzBuzz->execute());

        return 0;
    }


}
