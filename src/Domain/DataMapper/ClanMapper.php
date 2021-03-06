<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\IEntity;

/**
 * Class ClanMapper
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 1.0.0
 */
class ClanMapper extends DataMapper
{
    /**
     * ClanMapper constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 1.0.0
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'clan';
        $this->pdo = $pdo;
    }

    /**
     * Method to build a new object of ClanMapper.
     * @return ClanMapper The created object of ClanMapper.
     * @since 1.0.0
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a Clan on database.
     * @param IEntity $clan The Clan Entity.
     * @return bool The state if the Clan Entity was successfully created.
     * @since 1.0.0
     */
    public function create(IEntity $clan)
    {
        //check if a Clan is available.
        if (!($clan instanceof Clan)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (name, tag, website) VALUES (:name, :tag, :website);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':name', $clan->name, \PDO::PARAM_STR);
        $sth->bindParam(':tag', $clan->tag, \PDO::PARAM_STR);
        $sth->bindParam(':website', $clan->website, \PDO::PARAM_STR);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to delete a Clan on database.
     * @param IEntity $clan The Clan Entity.
     * @return bool The state if the Clan Entity was successfully deleted.
     * @since 1.0.0
     */
    public function delete(IEntity $clan)
    {
        //check if a Clan is available.
        if (!($clan instanceof Clan)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $clan->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to find Clan Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Clan Entities.
     * @return array An array with all found Clan Entities.
     * @since 1.0.0
     */
    public function find($condition = '')
    {
        return $this->findForEntity($condition, new Clan());
    }

    /**
     * Method to save a Clan on database.
     * @param IEntity $clan The Clan Entity.
     * @return bool The state if the Clan Entity was successfully saved.
     * @since 1.0.0
     */
    public function save(IEntity $clan)
    {
        //check if a Clan is available.
        if (!($clan instanceof Clan)) {
            return false;
        }

        //create or update the Clan.
        return ($clan->id > 0) ? $this->update($clan) : $this->create($clan);
    }

    /**
     * Method to update a Clan on database.
     * @param IEntity $clan The Clan Entity.
     * @return bool The state if the Clan Entity was successfully updated.
     * @since 1.0.0
     */
    public function update(IEntity $clan)
    {
        //check if a Clan is available.
        if (!($clan instanceof Clan)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET name = :name, tag = :tag, website = :website WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':name', $clan->name, \PDO::PARAM_STR);
        $sth->bindParam(':tag', $clan->tag, \PDO::PARAM_STR);
        $sth->bindParam(':website', $clan->website, \PDO::PARAM_STR);

        //execute the query and return the state.
        return $sth->execute();
    }
}
