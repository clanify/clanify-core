<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\Entity\User;

/**
 * Class UserRepository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
class UserRepository extends Repository
{
    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $table = 'user';

    /**
     * Method to find a User by email.
     * @param int $email The email of the User which will be searched.
     * @return array An array with all found User objects.
     * @since 0.0.1-dev
     */
    public function findByEmail($email)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.' WHERE email = :email';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute.
        $sth->bindParam(':email', $email, \PDO::PARAM_STR);
        $sth->execute();

        //execute the query and return the result as array.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class(new User()));
    }

    /**
     * Method to find a User by ID.
     * @param int $id The ID of the User which will be searched.
     * @return array An array with all found User objects.
     * @since 0.0.1-dev
     */
    public function findByID($id)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.' WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute.
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();

        //execute the query and return the result as array.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class(new User()));
    }

    /**
     * Method to find a User by username.
     * @param string $username The username of the User which will be searched.
     * @return array An array with all found User objects.
     * @since 0.0.1-dev
     */
    public function findByUsername($username)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.' WHERE username = :username';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute.
        $sth->bindParam(':username', $username, \PDO::PARAM_STR);
        $sth->execute();

        //execute the query and return the result as array.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class(new User()));
    }
}
