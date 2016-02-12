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
            $dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME;
            self::$pdo = new \PDO($dsn, DB_USER, DB_PASS);
        }

        //return the PDO database connection.
        return self::$pdo;
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
