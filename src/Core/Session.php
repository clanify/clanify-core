<?php
/**
 * Namespace for all core functions of Clanify.
 * @package Clanify\Core
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

/**
 * Class Session
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Core
 * @version 0.0.1-dev
 */
class Session
{
    /**
     * The PDO object to connect with the database.
     * @since 0.0.1-dev
     * @var \PDO|null
     */
    private $pdo = null;

    /**
     * The content of the session (content of global session array).
     * @since 0.0.1-dev
     * @var string
     */
    public $content = '';

    /**
     * The date & time at which the session was created as timestamp.
     * @since 0.0.1-dev
     * @var int
     */
    public $create_time = 0;

    /**
     * The ID of the session.
     * @since 0.0.1-dev
     * @var string
     */
    public $id = '';

    /**
     * Method to close the session.
     * @return bool The state if the session could be closed.
     * @since 0.0.1-dev
     */
    public function close()
    {
        $this->pdo = null;
        return true;
    }

    /**
     * Method to create the session and set the information.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 0.0.1-dev
     */
    public function create(\PDO $pdo)
    {
        //set the database connection.
        $this->pdo = $pdo;

        //override the session handler with the own.
        session_set_save_handler(
            array($this, "open"),
            array($this, "close"),
            array($this, "read"),
            array($this, "write"),
            array($this, "destroy"),
            array($this, "gc")
        );

        //start the session.
        session_start();
    }

    /**
     * Method to destroy the session.
     * @param string $id The ID of the session.
     * @return bool The state if the session was destroyed.
     * @since 0.0.1-dev
     */
    public function destroy($id)
    {
        //create and set the sql query.
        $sql = 'DELETE FROM session WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $id, \PDO::PARAM_STR);

        //execute the query and return the state.
        return $sth->execute();
    }

    /**
     * Method which represent the garbage collector to destroy expired sessions.
     * @param int $lifetime The lifetime of the session in seconds.
     * @return bool The state if the garbage collector was successful.
     * @since 0.0.1-dev
     */
    public function gc($lifetime)
    {
        //create and set the sql query.
        $sql = 'DELETE FROM session WHERE create_time < :expired';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindValue(':expired', (time() - $lifetime), \PDO::PARAM_INT);

        //execute the query and return the state.
        return $sth->execute();
    }

    /**
     * Method to open the session.
     * @return bool The state if the session could be opened.
     * @since 0.0.1-dev
     */
    public function open()
    {
        return ($this->pdo instanceof \PDO);
    }

    /**
     * Method to read the session from database.
     * @param string $id The ID of the session which will be read.
     * @return string The content of the session.
     * @since 0.0.1-dev
     */
    public function read($id)
    {
        //create and set the sql query.
        $sql = 'SELECT content FROM session WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $id, \PDO::PARAM_STR);

        //execute the query.
        if ($sth->execute()) {

            //get the row from database.
            if ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                return $row['content'];
            }
        }

        //return the default.
        return '';
    }

    /**
     * Method to write the session to the database.
     * @param string $id The ID of the session.
     * @param string $content The content of the session.
     * @return bool The state if the session could be written.
     * @since 0.0.1-dev
     */
    public function write($id, $content)
    {
        //create and set the sql query.
        $sql = 'REPLACE INTO session (id, content, create_time) VALUES (:id, :content, :create_time)';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $id, \PDO::PARAM_STR);
        $sth->bindParam(':content', $content, \PDO::PARAM_STR);
        $sth->bindValue(':create_time', time(), \PDO::PARAM_INT);

        //execute the query and return the state.
        return $sth->execute();
    }
}
