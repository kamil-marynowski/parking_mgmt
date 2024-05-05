<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

abstract class Repository
{
    protected function connectToDatabase(): PDO
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "parking_mgmt";

        try {

            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception
            // echo "Connected Successfully";

        } catch(PDOException $e) {

            echo "Connection Failed" .$e->getMessage();
        }

        return $conn;
    }

    abstract protected function findAll(): array;

    abstract protected function insert(array $data): void;
}