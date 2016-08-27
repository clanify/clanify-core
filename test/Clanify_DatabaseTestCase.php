<?php
/**
 * Namespace for testing Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test;

/**
 * Class Clanify_DatabaseTestCase
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test
 * @version 1.0.0
 */
abstract class Clanify_DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * The database connection with PDO.
     * @since 1.0.0
     * @var \PDO|null
     */
    static private $pdo = null;

    /**
     * The database connection for PHPUnit test cases.
     * @since 1.0.0
     * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection|null
     */
    private $connection = null;

    /**
     * Method to get the PHPUnit database connection.
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection|null
     * @since 1.0.0
     */
    final public function getConnection()
    {
        //check whether the PHPUnit database connection is available.
        if ($this->connection === null) {

            //check whether a PDO connection is available.
            if (self::$pdo === null) {
                self::$pdo = new \PDO(getenv('DB_DSN'), getenv('DB_USER'), getenv('DB_PASSWD'));
            }

            //create and set the PHPUnit database connection.
            $this->connection = $this->createDefaultDBConnection(self::$pdo, getenv('DB_DBNAME'));
        }

        //return the PHPUnit database connection.
        return $this->connection;
    }
}
