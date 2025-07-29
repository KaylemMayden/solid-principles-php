<?php

/**
 * DEPENDENCY INVERSION PRINCIPLE - BEFORE
 *
 * This code violates DIP because high-level modules depend directly on low-level modules.
 */

/**
 * Low-level module - specific MySQL connection implementation
 */
class MySQLConnection
{
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        echo "Connecting to MySQL database at {$this->host}...\n";
        // Actual MySQL connection logic would go here
        return "mysql_connection_resource";
    }

    public function query($sql)
    {
        echo "Executing MySQL query: {$sql}\n";
        // MySQL-specific query execution
        return "mysql_result";
    }
}

/**
 * High-level module that violates DIP
 * This design is problematic because PasswordReminder (high-level module)
 * depends directly on a low-level module (MySQLConnection).
 */
class PasswordReminder
{
    protected $dbConnection;

    /**
     * Why does this class care about needing a MySQLConnection?
     * This creates tight coupling and violates DIP.
     */
    public function __construct(MySQLConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function sendReminder($email)
    {
        // High-level business logic coupled to MySQL specifics
        $this->dbConnection->connect();

        $result = $this->dbConnection->query(
            "SELECT * FROM users WHERE email = '{$email}'"
        );

        if ($result) {
            echo "Sending password reminder to {$email}\n";
            // Email sending logic here
        }
    }
}

/**
 * Problems with this approach:
 *
 * 1. High-level modules depend on low-level modules
 * 2. Tight coupling to specific database implementation
 * 3. Hard to test (can't easily mock database)
 * 4. Inflexible (can't switch database types)
 * 5. Violates Dependency Inversion Principle
 * 6. Changes to MySQL implementation affect high-level modules
 * 7. Cannot reuse high-level modules with different databases
 */
