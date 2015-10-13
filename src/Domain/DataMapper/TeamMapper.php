<?php
/**
 * Namespace for all data mapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Domain\Entity\Team;

/**
 * Class TeamMapper
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 0.0.1-dev
 */
class TeamMapper extends DataMapper
{
    /**
     * The name of the table which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $table = 'team';

    /**
     * Method to create a Team on database.
     * @param Team $team The Entity of the Team.
     * @return bool The state if the Team was successfully created.
     * @since 0.0.1-dev
     */
    private function create(Team $team)
    {
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
     * @param Team $team The Entity of the Team.
     * @return bool The state if the Team was successfully deleted.
     * @since 0.0.1-dev
     */
    public function delete(Team $team)
    {
        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $team->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to save a Team on database.
     * @param Team $team The Entity of the Team.
     * @return bool The state if the Team was successfully saved.
     * @since 0.0.1-dev
     */
    public function save(Team $team)
    {
        return ($team->id > 0) ? $this->update($team) : $this->create($team);
    }

    /**
     * Method to update a Team on database.
     * @param Team $team The Entity of the Team.
     * @return bool The state if the Team was successfully updated.
     * @since 0.0.1-dev
     */
    private function update(Team $team)
    {
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
