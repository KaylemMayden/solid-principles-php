<?php

/**
 * DEPENDENCY INVERSION PRINCIPLE - AFTER
 *
 * This code adheres to DIP by making both high-level and low-level modules depend on abstractions (interfaces).
 */

/**
 * Abstraction that both high and low-level modules depend on
 */
interface ConnectionInterface
{
    public function connect();
    public function query($sql);
    public function disconnect();
}

/**
 * High-level module that depends on abstraction
 * PasswordReminder depends on this interface, not concrete implementations
 */
class PasswordReminder
{
    protected $connection;

    /**
     * Now depends on abstraction, not concrete implementation
     * This follows Dependency Inversion Principle
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function sendReminder($email)
    {
        // High-level business logic independent of database specifics
        $this->connection->connect();

        $result = $this->connection->query(
            "SELECT * FROM users WHERE email = '{$email}'"
        );

        if ($result) {
            echo "Sending password reminder to {$email}\n";
            // Email sending logic here
        }

        $this->connection->disconnect();
    }
}

/**
 * Low-level module - MySQL implementation
 * The low-level module implements the interface
 */
class MySQLConnection implements ConnectionInterface
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connected = false;

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
        $this->connected = true;
        return "mysql_connection_resource";
    }

    public function query($sql)
    {
        if (!$this->connected) {
            throw new Exception("Not connected to database");
        }
        echo "Executing MySQL query: {$sql}\n";
        return "mysql_result";
    }

    public function disconnect()
    {
        echo "Disconnecting from MySQL database...\n";
        $this->connected = false;
    }
}

/**
 * Alternative low-level module - PostgreSQL implementation
 * Can be used interchangeably with MySQL implementation
 */
class PostgreSQLConnection implements ConnectionInterface
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connected = false;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        echo "Connecting to PostgreSQL database at {$this->host}...\n";
        $this->connected = true;
        return "postgresql_connection_resource";
    }

    public function query($sql)
    {
        if (!$this->connected) {
            throw new Exception("Not connected to database");
        }
        echo "Executing PostgreSQL query: {$sql}\n";
        return "postgresql_result";
    }

    public function disconnect()
    {
        echo "Disconnecting from PostgreSQL database...\n";
        $this->connected = false;
    }
}

/**
 * Mock implementation for testing
 */
class MockConnection implements ConnectionInterface
{
    private $queries = [];

    public function connect()
    {
        echo "Mock database connection established\n";
        return "mock_connection";
    }

    public function query($sql)
    {
        $this->queries[] = $sql;
        echo "Mock query executed: {$sql}\n";
        return "mock_result";
    }

    public function disconnect()
    {
        echo "Mock database connection closed\n";
    }

    public function getQueries()
    {
        return $this->queries;
    }
}

/**
 * Benefits of this approach:
 *
 * 1. Both high and low-level modules depend on abstractions
 * 2. Easy to swap database implementations
 * 3. Highly testable with mock implementations
 * 4. Loose coupling between components
 * 5. Follows Dependency Inversion Principle
 * 6. High-level modules are reusable with different databases
 * 7. Changes to database implementation don't affect high-level modules
 * 8. Easier to maintain and extend
 */
