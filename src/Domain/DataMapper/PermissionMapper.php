<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\Permission;

/**
 * Class PermissionMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
class PermissionMapper extends DataMapper
{
    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $table = 'permission';

    /**
     * Method to create a Permission on database.
     * @param Permission $permission The Entity of the Permission.
     * @return bool The state if the Permission was successfully created.
     * @since 0.0.1-dev
     */
    private function create(Permission $permission)
    {
        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (name) VALUES (:name);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':name', $permission->name, \PDO::PARAM_STR);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to delete a Permission on database.
     * @param Permission $permission The Entity of the Permission.
     * @return bool The state if the Permission was successfully deleted.
     * @since 0.0.1-dev
     */
    public function delete(Permission $permission)
    {
        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $permission->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to save a Permission on database.
     * @param Permission $permission The Entity of the Permission.
     * @return bool The state if the Permission was successfully saved.
     * @since 0.0.1-dev
     */
    public function save(Permission $permission)
    {
        return ($permission->id > 0) ? $this->update($permission) : $this->create($permission);
    }

    /**
     * Method to update a Permission on database.
     * @param Permission $permission The Entity of the Permission.
     * @return bool The state if the Permission was successfully updated.
     * @since 0.0.1-dev
     */
    private function update(Permission $permission)
    {
        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET name = :name WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':name', $permission->name, \PDO::PARAM_STR);
        $sth->bindParam(':id', $permission->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }
}
