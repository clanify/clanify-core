<?php
/**
 * Namespace for all Domain Services of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Service;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Entity\User;

/**
 * Class TeamService
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Service
 * @version 0.0.1-dev
 */
class TeamService
{
    /**
     * Method to add an User Entity to a Team Entity.
     * @param Team $team The Team Entity which the User Entity is to be added.
     * @param User $user The User Entity which will be added to the Team Entity.
     * @return bool The state if the User Entity was successfully added.
     * @since 0.0.1-dev
     */
    public function addUser(Team $team, User $user)
    {
        //get the database connection.
        $database = Database::getInstance()->getConnection();

        //create and prepare the sql query.
        $sql = 'INSERT INTO team_user (team_id, user_id) VALUES (:team_id, :user_id);';
        $sth = $database->prepare($sql);

        //execute the query and return the state.
        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to remove an User Entity from a Team Entity.
     * @param Team $team The Team Entity which the User Entity is to be removed.
     * @param User $user The User Entity which will be removed from the Team Entity.
     * @return bool The state if the User Entity was successfully removed.
     * @since 0.0.1-dev
     */
    public function removeUser(Team $team, User $user)
    {
        //get the database connection.
        $database = Database::getInstance()->getConnection();

        //create and prepare the sql query.
        $sql = 'DELETE FROM team_user WHERE team_id = :team_id AND user_id = :user_id;';
        $sth = $database->prepare($sql);

        //execute the query and return the state.
        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);
        return $sth->execute();
    }
}
