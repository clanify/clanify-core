<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Core\Database;
use Clanify\Domain\DataMapper\RoleMapper;

/**
 * Class RoleRepository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
class RoleRepository extends Repository
{
    /**
     * Method to build a new object of RoleRepository.
     * @return RoleRepository The created object of RoleRepository.
     * @since 0.0.1-dev
     */
    public static function build()
    {
        $mapper = new RoleMapper(Database::getInstance()->getConnection());
        return new self($mapper);
    }

    /**
     * Method to find all Role Entities.
     * @return array An array with all found Role Entities.
     * @since 0.0.1-dev
     */
    public function findAll()
    {
        //check if a RoleMapper is available.
        if (!($this->dataMapper instanceof RoleMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Role Entities by ID.
     * @param int $id The ID to find the Role Entities.
     * @return array An array with all found Role Entities.
     * @since 0.0.1-dev
     */
    public function findByID($id)
    {
        //check if a RoleMapper is available.
        if (!($this->dataMapper instanceof RoleMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Role Entities by name.
     * @param string $name The name to find the Role Entities.
     * @return array An array with all found Role Entities.
     * @since 0.0.1-dev
     */
    public function findByName($name)
    {
        //check if a RoleMapper is available.
        if (!($this->dataMapper instanceof RoleMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($name)) {
            $condition = "name IN ('".implode("', '", $name)."')";
        } else {
            $condition = "name = '".$name."'";
        }

        //return the result of the RoleMapper.
        return $this->dataMapper->find($condition);
    }
}
