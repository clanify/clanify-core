<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\User;

/**
 * Class UserMapper
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 1.0.0
 */
class UserMapper extends DataMapper
{
    /**
     * UserMapper constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 1.0.0
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'user';
        $this->pdo = $pdo;
    }

    /**
     * Method to build a new object of UserMapper.
     * @return UserMapper The created object of UserMapper.
     * @since 1.0.0
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create an User on database.
     * @param IEntity $user The User Entity.
     * @return bool The state if the User Entity was successfully created.
     * @since 1.0.0
     */
    public function create(IEntity $user)
    {
        //check if a User is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (birthday, email, firstname, gender, lastname, password, salt, username) ';
        $sql .= 'VALUES (:birthday, :email, :firstname, :gender, :lastname, :password, :salt, :username);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':birthday', $user->birthday, \PDO::PARAM_STR);
        $sth->bindParam(':email', $user->email, \PDO::PARAM_STR);
        $sth->bindParam(':firstname', $user->firstname, \PDO::PARAM_STR);
        $sth->bindParam(':gender', $user->gender, \PDO::PARAM_STR);
        $sth->bindParam(':lastname', $user->lastname, \PDO::PARAM_STR);
        $sth->bindParam(':password', $user->password, \PDO::PARAM_STR);
        $sth->bindParam(':salt', $user->salt, \PDO::PARAM_STR);
        $sth->bindParam(':username', $user->username, \PDO::PARAM_STR);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to delete an User on database.
     * @param IEntity $user The User Entity.
     * @return bool The state if the User Entity was successfully deleted.
     * @since 1.0.0
     */
    public function delete(IEntity $user)
    {
        //check if a User is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $user->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to find User Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the User Entities.
     * @return array An array with all found User Entities.
     * @since 1.0.0
     */
    public function find($condition = '')
    {
        return $this->findForEntity($condition, new User());
    }

    /**
     * Method to save an User on database.
     * @param IEntity $user The User Entity.
     * @return bool The state if the User Entity was successfully saved.
     * @since 1.0.0
     */
    public function save(IEntity $user)
    {
        //check if a User is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create or update the User.
        return ($user->id > 0) ? $this->update($user) : $this->create($user);
    }

    /**
     * Method to update an User on database.
     * @param IEntity $user The User Entity.
     * @return bool The state if the User Entity was successfully updated.
     * @since 1.0.0
     */
    public function update(IEntity $user)
    {
        //check if a User is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET birthday = :birthday, email = :email, firstname = :firstname, ';
        $sql .= 'gender = :gender, lastname = :lastname, password = :password, salt = :salt, ';
        $sql .= 'username = :username WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':birthday', $user->birthday, \PDO::PARAM_STR);
        $sth->bindParam(':email', $user->email, \PDO::PARAM_STR);
        $sth->bindParam(':firstname', $user->firstname, \PDO::PARAM_STR);
        $sth->bindParam(':gender', $user->gender, \PDO::PARAM_STR);
        $sth->bindParam(':lastname', $user->lastname, \PDO::PARAM_STR);
        $sth->bindParam(':password', $user->password, \PDO::PARAM_STR);
        $sth->bindParam(':salt', $user->salt, \PDO::PARAM_STR);
        $sth->bindParam(':username', $user->username, \PDO::PARAM_STR);
        $sth->bindParam(':id', $user->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }
}
