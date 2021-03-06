<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\IEntity;

/**
 * Interface IDataMapper
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 1.0.0
 */
interface IDataMapper
{
    /**
     * IDataMapper constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 1.0.0
     */
    public function __construct(\PDO $pdo);

    /**
     * Method to build a new object of IDataMapper.
     * @return IDataMapper The created object of IDataMapper.
     * @since 1.0.0
     */
    public static function build();

    /**
     * Method to create an Entity on database.
     * @param IEntity $entity The Entity.
     * @return bool The state if the Entity was successfully created.
     * @since 1.0.0
     */
    public function create(IEntity $entity);

    /**
     * Method to delete an Entity on database.
     * @param IEntity $entity The Entity.
     * @return bool The state if the Entity was successfully deleted.
     * @since 1.0.0
     */
    public function delete(IEntity $entity);

    /**
     * Method to find Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Entities.
     * @return array An array with all found Entities.
     * @since 1.0.0
     */
    public function find($condition);

    /**
     * Method to save an Entity on database.
     * @param IEntity $entity The Entity.
     * @return bool The state if the Entity was successfully saved.
     * @since 1.0.0
     */
    public function save(IEntity $entity);

    /**
     * Method to update an Entity on database.
     * @param IEntity $entity The Entity.
     * @return bool The state if the Entity was successfully updated.
     * @since 1.0.0
     */
    public function update(IEntity $entity);
}
