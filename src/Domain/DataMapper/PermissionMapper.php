<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Permission;

/**
 * Class PermissionMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
class PermissionMapper extends DataMapper
{
    /**
     * PermissionMapper constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 0.0.1-dev
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'permission';
        $this->pdo = $pdo;
    }

    /**
     * Method to build a new object of PermissionMapper.
     * @return PermissionMapper The created object of PermissionMapper.
     * @since 0.0.1-dev
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a Permission on database.
     * @param IEntity $permission The Permission Entity.
     * @return bool The state if the Permission Entity was successfully created.
     * @since 0.0.1-dev
     */
    public function create(IEntity $permission)
    {
        //check if a Permission is available.
        if (!($permission instanceof Permission)) {
            return false;
        }

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
     * @param IEntity $permission The Permission Entity.
     * @return bool The state if the Permission Entity was successfully deleted.
     * @since 0.0.1-dev
     */
    public function delete(IEntity $permission)
    {
        //check if a Permission is available.
        if (!($permission instanceof Permission)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $permission->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to find Permission Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Permission Entities.
     * @return array An array with all found Permission Entities.
     * @since 0.0.1-dev
     */
    public function find($condition = '')
    {
        return $this->findForEntity($condition, new Permission());
    }

    /**
     * Method to save a Permission on database.
     * @param IEntity $permission The Permission Entity.
     * @return bool The state if the Permission Entity was successfully saved.
     * @since 0.0.1-dev
     */
    public function save(IEntity $permission)
    {
        //check if a Permission is available.
        if (!($permission instanceof Permission)) {
            return false;
        }

        //create or update the Permission.
        return ($permission->id > 0) ? $this->update($permission) : $this->create($permission);
    }

    /**
     * Method to update a Permission on database.
     * @param IEntity $permission The Permission Entity.
     * @return bool The state if the Permission Entity was successfully updated.
     * @since 0.0.1-dev
     */
    public function update(IEntity $permission)
    {
        //check if a Permission is available.
        if (!($permission instanceof Permission)) {
            return false;
        }

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
