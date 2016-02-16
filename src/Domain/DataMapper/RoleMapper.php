<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Role;

/**
 * Class RoleMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
class RoleMapper extends DataMapper
{
    /**
     * RoleMapper constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 0.0.1-dev
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'role';
        $this->pdo = $pdo;
    }

    /**
     * Method to create a Role on database.
     * @param IEntity $role The Role Entity.
     * @return bool The state if the Role Entity was successfully created.
     * @since 0.0.1-dev
     */
    public function create(IEntity $role)
    {
        //check if a Role is available.
        if (!($role instanceof Role)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (name) VALUES (:name);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':name', $role->name, \PDO::PARAM_STR);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to delete a Role on database.
     * @param IEntity $role The Role Entity.
     * @return bool The state if the Role Entity was successfully deleted.
     * @since 0.0.1-dev
     */
    public function delete(IEntity $role)
    {
        //check if a Role is available.
        if (!($role instanceof Role)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $role->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to find Role Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Role Entities.
     * @return array An array with all found Role Entities.
     * @since 0.0.1-dev
     */
    public function find($condition = '')
    {
        return $this->findForEntity($condition, new Role());
    }

    /**
     * Method to save a Role on database.
     * @param IEntity $role The Role Entity.
     * @return bool The state if the Role Entity was successfully saved.
     * @since 0.0.1-dev
     */
    public function save(IEntity $role)
    {
        //check if a Role is available.
        if (!($role instanceof Role)) {
            return false;
        }

        //create or update the Role.
        return ($role->id > 0) ? $this->update($role) : $this->create($role);
    }

    /**
     * Method to update a Role on database.
     * @param IEntity $role The Role Entity.
     * @return bool The state if the Role Entity was successfully updated.
     * @since 0.0.1-dev
     */
    public function update(IEntity $role)
    {
        //check if a Role is available.
        if (!($role instanceof Role)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET name = :name WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':name', $role->name, \PDO::PARAM_STR);
        $sth->bindParam(':id', $role->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }
}
