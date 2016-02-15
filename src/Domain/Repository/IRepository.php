<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\DataMapper\IDataMapper;

/**
 * Interface IRepository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
interface IRepository
{
    /**
     * IRepository constructor.
     * @param IDataMapper $dataMapper The DataMapper to use the database.
     * @since 0.0.1-dev
     */
    public function __construct(IDataMapper $dataMapper);

    /**
     * Method to find all Entities.
     * @return array An array with all found Entities.
     * @since 0.0.1-dev
     */
    public function findAll();

    /**
     * Method to find Entities by ID.
     * @param int $id The ID to find the Entities.
     * @return array An array with all found Entities.
     * @since 0.0.1-dev
     */
    public function findByID($id);
}
