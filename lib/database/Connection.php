<?php

namespace Lib\Database;

use Lib\Application\Singleton;
use PDO;
use PDOException;

class Connection
{
    use Singleton;

    /**
     * @var PDO
     */
    private $connection;

    public function connect()
    {
        try {
            $host     = $_ENV['DB_HOST'];
            $name     = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];

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