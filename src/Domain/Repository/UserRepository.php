<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\DataMapper\UserMapper;

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
     * Method to find all User Entities.
     * @return array An array with all found User Entities.
     * @since 0.0.1-dev
     */
    public function findAll()
    {
        //check if a UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find User Entities by ID.
     * @param int $id The ID to find the User Entities.
     * @return array An array with all found User Entities.
     * @since 0.0.1-dev
     */
    public function findByID($id)
    {
        //check if a UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find User Entities by email.
     * @param string $email The email to find the User Entities.
     * @return array An array with all found User Entities.
     * @since 0.0.1-dev
     */
    public function findByEmail($email)
    {
        //check if a UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($email)) {
            $condition = "email IN ('".implode("', '", $email)."')";
        } else {
            $condition = "email = '".$email."'";
        }

        //return the result of the UserMapper.
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find User Entities by username.
     * @param string $username The username to find the User Entities.
     * @return array An array with all found User Entities.
     * @since 0.0.1-dev
     */
    public function findByUsername($username)
    {
        //check if a UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($username)) {
            $condition = "username IN ('".implode("', '", $username)."')";
        } else {
            $condition = "username = '".$username."'";
        }

        //return the result of the UserMapper.
        return $this->dataMapper->find($condition);
    }
}
