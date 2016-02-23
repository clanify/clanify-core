<?php
/**
 * Namespace for all Domain Services of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Service;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Entity\User;

/**
 * Class ClanService
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Service
 * @version 0.0.1-dev
 */
class ClanService
{
    /**
     * Method to add an Team Entity to a Clan Entity.
     * @param Clan $clan The Clan Entity which the Team Entity is to be added.
     * @param Team $team The Team Entity which will be added to the Clan Entity.
     * @return bool The state if the Team Entity was successfully added.
     * @since 0.0.1-dev
     */
    public function addTeam(Clan $clan, Team $team)
    {
        //get the database connection.
        $database = Database::getInstance()->getConnection();

        //create and prepare the sql query.
        $sql = 'INSERT INTO clan_team (clan_id, team_id) VALUES (:clan_id, :team_id);';
        $sth = $database->prepare($sql);

        //execute the query and return the state.
        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to add an User Entity to a Clan Entity.
     * @param Clan $clan The Clan Entity which the User Entity is to be added.
     * @param User $user The User Entity which will be added to the Clan Entity.
     * @return bool The state if the User Entity was successfully added.
     * @since 0.0.1-dev
     */
    public function addUser(Clan $clan, User $user)
    {
        //get the database connection.
        $database = Database::getInstance()->getConnection();

        //create and prepare the sql query.
        $sql = 'INSERT INTO clan_user (clan_id, user_id) VALUES (:clan_id, :user_id);';
        $sth = $database->prepare($sql);

        //execute the query and return the state.
        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to remove a Team Entity from a Clan Entity.
     * @param Clan $clan The Clan Entity which the Team Entity is to be removed.
     * @param Team $team The Team Entity which will be removed from the Clan Entity.
     * @return bool The state if the Team Entity was successfully removed.
     * @since 0.0.1-dev
     */
    public function removeTeam(Clan $clan, Team $team)
    {
        //get the database connection.
        $database = Database::getInstance()->getConnection();

        //create and prepare the sql query.
        $sql = 'DELETE FROM clan_team WHERE clan_id = :clan_id AND team_id = :team_id;';
        $sth = $database->prepare($sql);

        //execute the query and return the state.
        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to remove an User Entity from a Clan Entity.
     * @param Clan $clan The Clan Entity which the User Entity is to be removed.
     * @param User $user The User Entity which will be removed from the Clan Entity.
     * @return bool The state if the User Entity was successfully removed.
     * @since 0.0.1-dev
     */
    public function removeUser(Clan $clan, User $user)
    {
        //get the database connection.
        $database = Database::getInstance()->getConnection();

        //create and prepare the sql query.
        $sql = 'DELETE FROM clan_user WHERE clan_id = :clan_id AND user_id = :user_id;';
        $sth = $database->prepare($sql);

        //execute the query and return the state.
        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);
        return $sth->execute();
    }
}
