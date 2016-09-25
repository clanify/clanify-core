<?php
/**
 * Namespace for all TableMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\TableMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Entity\User;

/**
 * TableMapper to persist the association between Team and User.
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\TableMapper
 * @version 1.0.0
 */
class TeamUserTableMapper extends TableMapper
{
    /**
     * Factory to get a initialized object of the TeamUserTableMapper.
     * @return TeamUserTableMapper The TeamUserTableMapper to persist the association on database.
     * @since 1.0.0
     * @uses Database::getInstance()->getConnection() to get a object of PDO.
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a new association between Team and User.
     * @param Team $team The Team which will be associated with the User.
     * @param User $user The User which will be associated with the Team.
     * @return boolean The state whether the Team could be associated with the User.
     * @since 1.0.0
     */
    public function create(Team $team, User $user)
    {
        //check whether a ID is available on the Team and User.
        if ($team->id <= 0 || $user->id <= 0) {
            return false;
        }

        //create the association in database and return the state.
        $sql = 'INSERT INTO `team_user` (`team_id`, `user_id`) VALUES (:team_id, :user_id);';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Method to delete the association between a Team and User.
     * @param Team $team The Team of the association with the User which will be removed.
     * @param User $user The User of the association with the Team which will be removed.
     * @return boolean The state whether the association between Team and User could be removed.
     * @since 1.0.0
     */
    public function delete(Team $team, User $user)
    {
        //check whether a ID is available on the Team and User.
        if ($team->id <= 0 || $user->id <= 0) {
            return false;
        }

        //delete the association in database and return the state.
        $sql = 'DELETE FROM `team_user` WHERE `team_id` = :team_id AND `user_id` = :user_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Method to delete all associations of the Team.
     * @param Team $team The Team which associations should be removed.
     * @return boolean The state whether all associations of the Team could be removed.
     * @since 1.0.0
     */
    public function deleteByTeam(Team $team)
    {
        //check whether a ID is available on the Team.
        if ($team->id <= 0) {
            return false;
        }

        //delete the associations of the Team in database and return the state.
        $sql = 'DELETE FROM `team_user` WHERE `team_id` = :team_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Method to delete all associations of the User.
     * @param User $user The User which associations should be removed.
     * @return boolean The state whether all associations of the User could be removed.
     * @since 1.0.0
     */
    public function deleteByUser(User $user)
    {
        //check whether a ID is available on the User.
        if ($user->id <= 0) {
            return false;
        }

        //delete the associations of the User in database and return the state.
        $sql = 'DELETE FROM `team_user` WHERE `user_id` = :user_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        return $sth->execute();
    }
}
