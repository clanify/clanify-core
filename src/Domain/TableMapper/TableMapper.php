<?php
/**
 * Namespace for all TableMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\TableMapper;

/**
 * TableMapper to persist the association between two Entities.
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\TableMapper
 * @version 1.0.0
 */
abstract class TableMapper
{
    /**
     * The PDO database connection.
     * @since 1.0.0
     * @var \PDO|null
     */
    protected $pdo = null;

    /**
     * TableMapper constructor to initialize the object.
     * @param \PDO $pdo The PDO database connection.
     * @since 1.0.0
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Factory to get a initialized object of the TableMapper.
     * @return TableMapper The TableMapper to persist the association on database.
     * @since 1.0.0
     */
    abstract static function build();
}
