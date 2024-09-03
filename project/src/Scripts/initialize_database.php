<?php

require_once '../../vendor/autoload.php';

use App\Services\DatabaseService;

// Database configuration
$servername = "db";
$username = "user";
$password = "password";
$dbname = "mydatabase";

// Initialize the DatabaseService
$dbService = DatabaseService::getInstance($servername, $username, $password, $dbname);
$conn = $dbService->getConnection();

echo "Checking and initializing database...\n";

// Check and create the 'categories' table if it does not exist
if (!$dbService->tableExists('categories')) {
    echo "Creating 'categories' table...\n";
    $path = __DIR__ . '/../../database/create_categories_table.sql';
    print($path);
    $dbService->runSqlFile($path);
}

// Check and create the 'users' table if it does not exist
if (!$dbService->tableExists('users')) {
    echo "Creating 'users' table...\n";
    $dbService->runSqlFile(__DIR__ . '/../../database/create_users_table.sql');
}

// Check and create the 'user_categories' table if it does not exist
if (!$dbService->tableExists('user_categories')) {
    echo "Creating 'user_categories' table...\n";
    $dbService->runSqlFile(__DIR__ . '/../../database/create_user_categories_table.sql');
}

// If all tables are created, populate them
if ($dbService->tableExists('categories') && $dbService->tableExists('users') && $dbService->tableExists('user_categories')) {
    echo "Populating tables...\n";
    $dbService->runSqlFile(__DIR__ . '/../../database/populate_tables.sql');
    echo "Database initialized successfully.\n";
} else {
    echo "Some tables are missing, and the database was not fully initialized.\n";
}

// Close the connection
$dbService->close();
