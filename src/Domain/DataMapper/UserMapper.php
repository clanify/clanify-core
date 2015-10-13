<?php
/**
 * Namespace for all data mapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\User;

/**
 * Class UserMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
class UserMapper extends DataMapper
{
    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $table = 'user';

    /**
     * Method to create a User on database.
     * @param User $user The Entity of the User.
     * @return bool The state if the User was successfully created.
     * @since 0.0.1-dev
     */
    private function create(User $user)
    {
        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (birthday, email, firstname, gender, lastname, password, username) ';
        $sql .= 'VALUES (:birthday, :email, :firstname, :gender, :lastname, :password, :username);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':birthday', $user->birthday, \PDO::PARAM_STR);
        $sth->bindParam(':email', $user->email, \PDO::PARAM_STR);
        $sth->bindParam(':firstname', $user->firstname, \PDO::PARAM_STR);
        $sth->bindParam(':gender', $user->gender, \PDO::PARAM_STR);
        $sth->bindParam(':lastname', $user->lastname, \PDO::PARAM_STR);
        $sth->bindParam(':password', $user->password, \PDO::PARAM_STR);
        $sth->bindParam(':username', $user->username, \PDO::PARAM_STR);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to delete a User on database.
     * @param User $user The Entity of the User.
     * @return bool The state if the User was successfully deleted.
     * @since 0.0.1-dev
     */
    public function delete(User $user)
    {
        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $user->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to save a User on database.
     * @param User $user The Entity of the User.
     * @return bool The state if the User was successfully saved.
     * @since 0.0.1-dev
     */
    public function save(User $user)
    {
        return ($user->id > 0) ? $this->update($user) : $this->create($user);
    }

    /**
     * Method to update a User on database.
     * @param User $user The Entity of the User.
     * @return bool The state if the User was successfully updated.
     * @since 0.0.1-dev
     */
    private function update(User $user)
    {
        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET birthday = :birthday, email = :email, firstname = :firstname, ';
        $sql .= 'gender = :gender, lastname = :lastname, password = :password, username = :username WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':birthday', $user->birthday, \PDO::PARAM_STR);
        $sth->bindParam(':email', $user->email, \PDO::PARAM_STR);
        $sth->bindParam(':firstname', $user->firstname, \PDO::PARAM_STR);
        $sth->bindParam(':gender', $user->gender, \PDO::PARAM_STR);
        $sth->bindParam(':lastname', $user->lastname, \PDO::PARAM_STR);
        $sth->bindParam(':password', $user->password, \PDO::PARAM_STR);
        $sth->bindParam(':username', $user->username, \PDO::PARAM_STR);
        $sth->bindParam(':id', $user->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }
}
