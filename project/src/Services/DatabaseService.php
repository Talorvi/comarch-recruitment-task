<?php

namespace App\Services;

use mysqli;

class DatabaseService
{
    private static ?DatabaseService $instance = null;
    private mysqli $conn;

    private function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Static method to get the singleton instance
    public static function getInstance($servername, $username, $password, $dbname): ?DatabaseService
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseService($servername, $username, $password, $dbname);
        }
        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }

    public function tableExists($table): bool
    {
        $result = $this->conn->query("SHOW TABLES LIKE '$table'");
        return $result && $result->num_rows > 0;
    }

    public function runSqlFile($filePath): void
    {
        $sql = file_get_contents($filePath);
        if ($sql === false) {
            echo "Error: Unable to read the SQL file at $filePath\n";
            return;
        }

        if ($this->conn->multi_query($sql)) {
            do {
                if ($result = $this->conn->store_result()) {
                    $result->free();
                }
            } while ($this->conn->next_result());
        } else {
            echo "Error running SQL file: " . $this->conn->error . "\n";
        }
    }

    // For testing purposes
    public static function resetInstance(): void
    {
        self::$instance = null;
    }

    public function close(): void
    {
        $this->conn->close();
    }
}
