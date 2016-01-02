<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\Role;

/**
 * Class RoleMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
class RoleMapper extends DataMapper
{
    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $table = 'role';

    /**
     * Method to create a Role on database.
     * @param Role $role The Entity of the Role.
     * @return bool The state if the Role was successfully created.
     * @since 0.0.1-dev
     */
    private function create(Role $role)
    {
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
     * @param Role $role The Entity of the Role.
     * @return bool The state if the Role was successfully deleted.
     * @since 0.0.1-dev
     */
    public function delete(Role $role)
    {
        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $role->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to save a Role on database.
     * @param Role $role The Entity of the Role.
     * @return bool The state if the Role was successfully saved.
     * @since 0.0.1-dev
     */
    public function save(Role $role)
    {
        return ($role->id > 0) ? $this->update($role) : $this->create($role);
    }

    /**
     * Method to update a Role on database.
     * @param Role $role The Entity of the Role.
     * @return bool The state if the Role was successfully updated.
     * @since 0.0.1-dev
     */
    private function update(Role $role)
    {
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
