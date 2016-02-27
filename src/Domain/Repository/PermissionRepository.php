<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\DataMapper\PermissionMapper;

/**
 * Class PermissionRepository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
class PermissionRepository extends Repository
{
    /**
     * Method to build a new object of PermissionRepository.
     * @return PermissionRepository The created object of PermissionRepository.
     * @since 0.0.1-dev
     */
    public static function build()
    {
        return new self(PermissionMapper::build());
    }

    /**
     * Method to find all Permission Entities.
     * @return array An array with all found Permission Entities.
     * @since 0.0.1-dev
     */
    public function findAll()
    {
        //check if a PermissionMapper is available.
        if (!($this->dataMapper instanceof PermissionMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Permission Entities by ID.
     * @param int $id The ID to find the Permission Entities.
     * @return array An array with all found Permission Entities.
     * @since 0.0.1-dev
     */
    public function findByID($id)
    {
        //check if a PermissionMapper is available.
        if (!($this->dataMapper instanceof PermissionMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Permission Entities by name.
     * @param string $name The name to find the Permission Entities.
     * @return array An array with all found Permission Entities.
     * @since 0.0.1-dev
     */
    public function findByName($name)
    {
        //check if a PermissionMapper is available.
        if (!($this->dataMapper instanceof PermissionMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($name)) {
            $condition = "name IN ('".implode("', '", $name)."')";
        } else {
            $condition = "name = '".$name."'";
        }

        //return the result of the PermissionMapper.
        return $this->dataMapper->find($condition);
    }
}
