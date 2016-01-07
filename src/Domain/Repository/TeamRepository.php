<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\Entity\Team;

/**
 * Class TeamRepository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
class TeamRepository extends Repository
{
    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $table = 'team';

    /**
     * Method to find a Team by id.
     * @param int $id The id of the Team which will be searched.
     * @return array An array with all found Team objects.
     * @since 0.0.1-dev
     */
    public function findByID($id)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.' WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute.
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();

        //execute the query and return the result as array.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class(new Team()));
    }

    /**
     * Method to find a Team by name.
     * @param string $name The name of the Team which will be searched.
     * @return array An array with all found Team objects.
     * @since 0.0.1-dev
     */
    public function findByName($name)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.' WHERE name = :name';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute.
        $sth->bindParam(':name', $name, \PDO::PARAM_STR);
        $sth->execute();

        //execute the query and return the result as array.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class(new Team()));
    }

    /**
     * Method to find a Team by tag.
     * @param string $tag The tag of the Team which will be searched.
     * @return array An array with all found Team objects.
     * @since 0.0.1-dev
     */
    public function findByTag($tag)
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.' WHERE tag = :tag';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute.
        $sth->bindParam(':tag', $tag, \PDO::PARAM_STR);
        $sth->execute();

        //execute the query and return the result as array.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class(new Team()));
    }
}
