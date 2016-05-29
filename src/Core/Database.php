<?php
/**
 * Namespace for all core functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

/**
 * Class Database
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core
 * @version 0.0.1-dev
 */
class Database
{
    /**
     * The instance of the Database.
     * @since 0.0.1-dev
     * @var Database|null
     */
    private static $instance = null;

    /**
     * The PDO database connection.
     * @since 0.0.1-dev
     * @var \PDO|null
     */
    private static $pdo = null;

    /**
     * Private constructor to prevent creating a new instance.
     * @since 0.0.1-dev
     */
    private function __construct()
    {

    }

    /**
     * Private clone method to prevent cloning of the instance.
     * @since 0.0.1-dev
     */
    private function __clone()
    {

    }

    /**
     * Method to get a PDO database connection.
     * @return \PDO|null The PDO database connection.
     * @since 0.0.1-dev
     */
    public function getConnection()
    {
        //check if a PDO database connection is available.
        if (self::$pdo === null) {
            $this->setConnection(DB_NAME, DB_HOST, DB_USER, DB_PASS, DB_PORT);
        }

        //return the PDO database connection.
        return self::$pdo;
    }

    /**
     * Method to set the PDO database connection.
     * @param string $name The name of the database.
     * @param string $hostname The hostname of the database server.
     * @param string $username The username of the database.
     * @param string $password The password of the database.
     * @param int $port The port of the database on the database server.
     * @return boolean The state if the connection is successfully.
     * @since 0.0.1-dev
     */
    public function setConnection($name, $hostname, $username, $password, $port = 3306)
    {
        try {
            $dsn = 'mysql:host='.$hostname.';port='.$port.';dbname='.$name;
            self::$pdo = new \PDO($dsn, $username, $password);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Method to get the instance of the Database.
     * @return Database|null The instance of the Database.
     * @since 0.0.1-dev
     */
    public static function getInstance()
    {
        //check if a instance is available.
        if (self::$instance === null) {
            self::$instance = new self();
        }

        //return the instance.
        return self::$instance;
    }
}
