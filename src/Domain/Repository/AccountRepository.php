<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\DataMapper\AccountMapper;
use Clanify\Domain\Entity\User;

/**
 * Class AccountRepository
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 1.0.0
 */
class AccountRepository extends Repository
{
    /**
     * Method to build a new object of AccountRepository.
     * @return AccountRepository The created object of AccountRepository.
     * @since 1.0.0
     * @uses AccountMapper::build() to get the Account Entities from database.
     */
    public static function build()
    {
        return new self(AccountMapper::build());
    }

    /**
     * Method to find all Account Entities.
     * @return array An array with all found Account Entities.
     * @since 1.0.0
     */
    public function findAll()
    {
        //check if a AccountMapper is available.
        if (!($this->dataMapper instanceof AccountMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Account Entities by ID.
     * @param int $id The ID to find the Account Entities.
     * @return array An array with all found Account Entities.
     * @since 1.0.0
     */
    public function findByID($id)
    {
        //check if a AccountMapper is available.
        if (!($this->dataMapper instanceof AccountMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Account Entities by User Entity.
     * @param User $user The User Entity to find the Account Entities.
     * @return array An Array with all found Account Entities.
     * @since 1.0.0
     */
    public function findByUser(User $user)
    {
        //check if a AccountMapper is available.
        if (!($this->dataMapper instanceof AccountMapper)) {
            return [];
        } else {
            $condition = '`id` IN (SELECT `account_id` FROM `account_user` WHERE `user_id` = '.$user->id.')';
            return $this->dataMapper->find($condition);
        }
    }
}
