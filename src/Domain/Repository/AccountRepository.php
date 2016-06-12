<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\DataMapper\AccountMapper;

/**
 * Class AccountRepository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
class AccountRepository extends Repository
{
    /**
     * Method to build a new object of AccountRepository.
     * @return AccountRepository The created object of AccountRepository.
     * @since 0.0.1-dev
     */
    public static function build()
    {
        return new self(AccountMapper::build());
    }

    /**
     * Method to find all Account Entities.
     * @return array An array with all found Account Entities.
     * @since 0.0.1-dev
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
     * @since 0.0.1-dev
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
}
