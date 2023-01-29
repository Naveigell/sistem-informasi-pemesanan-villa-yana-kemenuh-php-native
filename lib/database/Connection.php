<?php

namespace Lib\Database;

use Lib\Application\Singleton;
use PDO;
use PDOException;

class Connection
{
    use Singleton;

    const HOST_NAME = "localhost";
    const DATABASE_USERNAME = "root";
    const DATABASE_PASSWORD = "root";
    const DATABASE_NAME = "yana_villa_kemenuh";

    /**
     * @var PDO
     */
    private $connection;

    public function connect()
    {
        try {
            $host     = self::HOST_NAME;
            $name     = self::DATABASE_NAME;
            $username = self::DATABASE_USERNAME;
            $password = self::DATABASE_PASSWORD;

            $this->connection = new PDO("mysql:host={$host};dbname={$name}", $username, $password);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}