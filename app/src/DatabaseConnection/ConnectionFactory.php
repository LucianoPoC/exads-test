<?php

declare(strict_types=1);

namespace App\DatabaseConnection;

final class ConnectionFactory
{
    public function get(): \mysqli
    {
        return new \mysqli('mysql', 'root', 'exads_root_password', 'exads_test_db');
    }
}
