<?php

namespace app\core;

use PDO;

class Database
{
    public PDO $pdo;

    public function __construct(string $dbDsn, string $dbUser, string $dbPassword)
    {
        $this->pdo = new PDO($dbDsn, $dbUser, $dbPassword);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}