<?php

declare(strict_types=1);

namespace App\DatabaseConnection;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateDatabaseCommand extends Command
{
    private const CREATE_TABLE = '
create table if not exists `exads_test` (
    `name` varchar(250) NOT NULL,
    `age` smallint NOT NULL,
    `job_title` varchar(250) NOT NULL,
    PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
';

    private const POPULATE_TABLE = '
insert into `exads_test` 
    (`name`, `age`, `job_title`) VALUES 
    ("John Doe", 23, "DBA"),
    ("Jane Doe", 29, "CEO"),
    ("Uncle Bob", 68, "Jedi Engineer"),
    ("Martin Fowler", 57, "CTO"),
    ("Andy Hunt", 39, "Writer"),
    ("Dave Thomas", 44, "Writer");
';

    private const ARGUMENT_NAME = 'name';
    private const ARGUMENT_AGE = 'age';
    private const ARGUMENT_JOB_TITLE = 'job_title';

    private ConnectionFactory $factory;

    public function __construct(string $name = null, ConnectionFactory $factory)
    {
        parent::__construct($name);

        $this->factory = $factory;
    }

    protected function configure(): void
    {
        $this->setName('exads:challenge:database:create')
            ->setDescription('Create database and table for Exads test.')
            ->addArgument(self::ARGUMENT_NAME, InputArgument::OPTIONAL, 'Name field for the record')
            ->addArgument(self::ARGUMENT_AGE, InputArgument::OPTIONAL, 'Age field for the record')
            ->addArgument(self::ARGUMENT_JOB_TITLE, InputArgument::OPTIONAL, 'Job title field for the record')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connection = $this->factory->get();

        if (!$connection) {
            $output->writeln(sprintf('Connection error: %s', mysqli_connect_error()));
            return 1;
        }

        if (\mysqli_query($connection, self::CREATE_TABLE)) {
            $output->writeln(sprintf('Table %s successfully created', 'exads_test'));
        } else {
            $output->writeln(sprintf('MySQL error: %s', mysqli_error($connection)));
            $connection->close();
            return 2;
        }

        if (\mysqli_query($connection, 'truncate table `exads_test`')) {
            $output->writeln(sprintf('Table %s successfully truncated', 'exads_test'));
        } else {
            $output->writeln(sprintf('MySQL error: %s', mysqli_error($connection)));
            $connection->close();
            return 3;
        }

        if (\mysqli_query($connection, self::POPULATE_TABLE)) {
            $output->writeln(sprintf('Table %s successfully populated', 'exads_test'));
        } else {
            $output->writeln(sprintf('MySQL error: %s', mysqli_error($connection)));
            $connection->close();
            return 4;
        }

        if (!empty($input->getArguments())) {
            $name = filter_var($input->getArgument(self::ARGUMENT_NAME), FILTER_SANITIZE_STRING);
            $age = filter_var($input->getArgument(self::ARGUMENT_AGE), FILTER_SANITIZE_NUMBER_INT);
            $jobTitle = filter_var($input->getArgument(self::ARGUMENT_JOB_TITLE), FILTER_SANITIZE_STRING);

            $query = "insert into `exads_test` (`name`, `age`, `job_title`) VALUES ('$name', $age, '$jobTitle')";

            if (\mysqli_query($connection, $query)) {
                $output->writeln(sprintf('Record %s inserted', $name));
            } else {
                $output->writeln(sprintf('MySQL error: %s', mysqli_error($connection)));
                $connection->close();
                return 5;
            }
        }

        $connection->close();

        return 0;
    }
}
