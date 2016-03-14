<?php
/**
 * Namespace for all logging output handler of Clanify.
 * @package Clanify\Core\Log\Output
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Log\Output;

/**
 * Class Database
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Log\Output
 * @version 0.0.1-dev
 */
class Database implements Output
{
    /**
     * The PDO object to connect with the database.
     * @since 0.0.1-dev
     * @var \PDO|null
     */
    private $pdo = null;

    /**
     * Database constructor.
     * @param \PDO $pdo The PDO object to connect with the database.
     * @since 0.0.1-dev
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Database destructor.
     * @since 0.0.1-dev
     */
    public function __destruct()
    {
        $this->pdo = null;
    }

    /**
     * Method to write the log message to the Database.
     * @param string $message The log message which will be written to the output.
     * @return bool The state if the log message was written to the output.
     * @since 0.0.1-dev
     */
    public function write($message)
    {
        //set the sql query to prepare.
        $sth = $this->pdo->prepare('INSERT INTO log SET message = :message');

        //bind the parameter and execute the query.
        $sth->bindParam(':message', $message, \PDO::PARAM_STR);
        return $sth->execute();
    }
}
