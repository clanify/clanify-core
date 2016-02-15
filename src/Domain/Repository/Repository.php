<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\DataMapper\IDataMapper;

/**
 * Class Repository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
abstract class Repository implements IRepository
{
    /**
     * The DataMapper which will be used for database connection.
     * @since 0.0.1-dev
     * @var null
     */
    protected $dataMapper = null;

    /**
     * Repository constructor.
     * @param IDataMapper $dataMapper The DataMapper to use the database.
     * @since 0.0.1-dev
     */
    public function __construct(IDataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * Method to find all Entities.
     * @param string $className The full class name of the DataMapper.
     * @return array An array with all found Entities.
     * @since 0.0.1-dev
     */
    protected function findAllEntities($className)
    {
        //check if a specific DataMapper is available.
        if (!($this->dataMapper instanceof $className)) {
            return [];
        }

        //return the result of the DataMapper.
        return $this->dataMapper->find('');
    }

    /**
     * Method to find Entities by ID.
     * @param int $id The ID to find the Entities.
     * @param string $className The full class name of the DataMapper.
     * @return array An array with all found Entities.
     * @since 0.0.1-dev
     */
    protected function findEntityByID($id, $className)
    {
        //check if a specific DataMapper is available.
        if (!($this->dataMapper instanceof $className)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($id)) {
            $condition = 'id IN ('.implode(', ', $id).')';
        } else {
            $condition = 'id = '.$id;
        }

        //return the result of the DataMapper.
        return $this->dataMapper->find($condition);
    }
}
