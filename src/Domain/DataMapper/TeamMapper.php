<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Team;

/**
 * Class TeamMapper
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 1.0.0
 */
class TeamMapper extends DataMapper
{
    /**
     * TeamMapper constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 1.0.0
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'team';
        $this->pdo = $pdo;
    }

    /**
     * Method to build a new object of TeamMapper.
     * @return TeamMapper The created object of TeamMapper.
     * @since 1.0.0
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a Team on database.
     * @param IEntity $team The Team Entity.
     * @return bool The state if the Team Entity was successfully created.
     * @since 1.0.0
     */
    public function create(IEntity $team)
    {
        //check if a Team is available.
        if (!($team instanceof Team)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (name, tag, website) VALUES (:name, :tag, :website);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':name', $team->name, \PDO::PARAM_STR);
        $sth->bindParam(':tag', $team->tag, \PDO::PARAM_STR);
        $sth->bindParam(':website', $team->website, \PDO::PARAM_STR);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to delete a Team on database.
     * @param IEntity $team The Team Entity.
     * @return bool The state if the Team Entity was successfully deleted.
     * @since 1.0.0
     */
    public function delete(IEntity $team)
    {
        //check if a Team is available.
        if (!($team instanceof Team)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $team->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to find Team Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function find($condition = '')
    {
        return $this->findForEntity($condition, new Team());
    }

    /**
     * Method to save a Team on database.
     * @param IEntity $team The Team Entity.
     * @return bool The state if the Team Entity was successfully saved.
     * @since 1.0.0
     */
    public function save(IEntity $team)
    {
        //check if a Team is available.
        if (!($team instanceof Team)) {
            return false;
        }

        //create or update the Team.
        return ($team->id > 0) ? $this->update($team) : $this->create($team);
    }

    /**
     * Method to update a Team on database.
     * @param IEntity $team The Team Entity.
     * @return bool The state if the Team Entity was successfully updated.
     * @since 1.0.0
     */
    public function update(IEntity $team)
    {
        //check if a Team is available.
        if (!($team instanceof Team)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET name = :name, tag = :tag, website = :website WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $team->id, \PDO::PARAM_INT);
        $sth->bindParam(':name', $team->name, \PDO::PARAM_STR);
        $sth->bindParam(':tag', $team->tag, \PDO::PARAM_STR);
        $sth->bindParam(':website', $team->website, \PDO::PARAM_STR);

        //execute the query and return the state.
        return $sth->execute();
    }
}
