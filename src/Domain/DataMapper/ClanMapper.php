<?php
/**
 * Namespace for all data mapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use \Clanify\Domain\Entity\Clan;

/**
 * Class ClanMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
class ClanMapper extends DataMapper
{
    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $table = 'clan';

    /**
     * Method to create a Clan on database.
     * @param Clan $clan The Entity of the Clan.
     * @return bool The state if the Clan was successfully created.
     * @since 0.0.1-dev
     */
    private function create(Clan $clan)
    {
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
     * @param Clan $clan The Entity of the Clan.
     * @return bool The state if the Clan was successfully deleted.
     * @since 0.0.1-dev
     */
    public function delete(Clan $clan)
    {
        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $clan->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to save a Clan on database.
     * @param Clan $clan The Entity of the Clan.
     * @return bool The state if the Clan was successfully saved.
     * @since 0.0.1-dev
     */
    public function save(Clan $clan)
    {
        return ($clan->id > 0) ? $this->update($clan) : $this->create($clan);
    }

    /**
     * Method to update a Clan on database.
     * @param Clan $clan The Entity of the Clan.
     * @return bool The state if the Clan was successfully updated.
     * @since 0.0.1-dev
     */
    private function update(Clan $clan)
    {
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
