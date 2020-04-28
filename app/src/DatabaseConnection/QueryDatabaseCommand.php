<?php

declare(strict_types=1);

namespace App\DatabaseConnection;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class QueryDatabaseCommand extends Command
{
    private const QUERY_ALL_RECORDS = '
select `name`, `age`, `job_title` from `exads_test`;
    ';

    private ConnectionFactory $factory;

    public function __construct(string $name = null, ConnectionFactory $factory)
    {
        parent::__construct($name);
        $this->factory = $factory;
    }

    protected function configure(): void
    {
        $this->setName('exads:challenge:database:query')
            ->setDescription('Query table Exads test.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connection = $this->factory->get();

        if (!$connection) {
            $output->writeln(sprintf('Connection error: %s', mysqli_connect_error()));
            return 1;
        }

        $result = \mysqli_query($connection, self::QUERY_ALL_RECORDS);

        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $output->writeln(str_repeat('-', 100));
        foreach ($rows as $position => $fields) {
            $output->writeln(sprintf('Record #%u:', $position));
            foreach ($fields as $field => $value) {
                $output->writeln(sprintf('%s: %s', $field, $value));
            }
            $output->writeln(str_repeat('-', 100));
        }

        $connection->close();

        return 0;
    }

}
