<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\IEntity;

/**
 * Class DataMapper
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 1.0.0
 */
abstract class DataMapper implements IDataMapper
{
    /**
     * The PDO object to use the database.
     * @since 1.0.0
     * @var \PDO|null
     */
    protected $pdo = null;

    /**
     * The name of the table which will be used.
     * @since 1.0.0
     * @var string
     */
    protected $table = '';

    /**
     * Method to find Entities by a SQL condition for an Entity.
     * @param string $condition The SQL condition to filter the Entities.
     * @param IEntity $entity The object of the Entity which will be loaded.
     * @return array An array with all found Entities.
     * @since 1.0.0
     */
    protected function findForEntity($condition, IEntity $entity)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.((trim($condition) !== '') ? ' WHERE '.$condition : '');
        $sth = $this->pdo->prepare($sql);

        //execute the query.
        $sth->execute();

        //fetch all the results as Entities.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class($entity));
    }
}
