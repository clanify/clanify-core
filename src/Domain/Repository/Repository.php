<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

/**
 * Class Repository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @version 0.0.1-dev
 */
abstract class Repository
{
    /**
     * The PDO connection to use the database.
     * @since 0.0.1-dev
     * @var null|\PDO
     */
    protected $pdo = null;

    /**
     * Constructor to initialize the data mapper with a PDO connection.
     * @param \PDO $pdo The PDO connection.
     * @since 0.0.1-dev
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
