<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\IEntity;

/**
 * Class DataMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
abstract class DataMapper implements IDataMapper
{
    /**
     * The PDO object to use the database.
     * @since 0.0.1-dev
     * @var null|\PDO
     */
    protected $pdo = null;

    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    public $table = '';

    /**
     * DataMapper constructor.
     * @param \PDO $pdo The PDO object.
     * @since 0.0.1-dev
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = ($pdo instanceof \PDO) ? $pdo : null;
    }

    /**
     * Method to find Entities by a SQL condition for a Entity.
     * @param string $condition The SQL condition to filter the Entities.
     * @param IEntity $entity The object of the Entity which will be loaded.
     * @return array An array with all found Entities.
     * @since 0.0.1-dev
     */
    protected function findForEntity($condition, IEntity $entity)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.(trim($condition) !== '') ? ' WHERE '.$condition : '';
        $sth = $this->pdo->prepare($sql);

        //execute the query.
        $sth->execute();

        //fetch all the results as Entities.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class($entity));
    }
}
