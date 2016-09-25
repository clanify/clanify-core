<?php
/**
 * Namespace for all TableMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\TableMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;

/**
 * TableMapper to persist the association between Clan and Team.
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\TableMapper
 * @version 1.0.0
 */
class ClanTeamTableMapper extends TableMapper
{
    /**
     * Factory to get a initialized object of the ClanTeamTableMapper.
     * @return ClanTeamTableMapper The ClanTeamTableMapper to persist the association on database.
     * @since 1.0.0
     * @uses Database::getInstance()->getConnection() to get a object of PDO.
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a new association between Clan and Team.
     * @param Clan $clan The Clan which will be associated with the Team.
     * @param Team $team The Team which will be associated with the Clan.
     * @return boolean The state whether the Clan could be associated with the Team.
     * @since 1.0.0
     */
    public function create(Clan $clan, Team $team)
    {
        //check whether a ID is available on the Clan and Team.
        if ($clan->id <= 0 || $team->id <= 0) {
            return false;
        }

        //create the association in database and return the state.
        $sql = 'INSERT INTO `clan_team` (`clan_id`, `team_id`) VALUES (:clan_id, :team_id);';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Method to delete the association between a Clan and Team.
     * @param Clan $clan The Clan of the association with the Team which will be removed.
     * @param Team $team The Team of the association with the Clan which will be removed.
     * @return boolean The state whether the association between Clan and Team could be removed.
     * @since 1.0.0
     */
    public function delete(Clan $clan, Team $team)
    {
        //check whether a ID is available on the Clan and Team.
        if ($clan->id <= 0 || $team->id <= 0) {
            return false;
        }

        //delete the association in database and return the state.
        $sql = 'DELETE FROM `clan_team` WHERE `clan_id` = :clan_id AND `team_id` = :team_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Method to delete all associations of the Clan.
     * @param Clan $clan The Clan which associations should be removed.
     * @return boolean The state whether all associations of the Clan could be removed.
     * @since 1.0.0
     */
    public function deleteByClan(Clan $clan)
    {
        //check whether a ID is available on the Clan.
        if ($clan->id <= 0) {
            return false;
        }

        //delete the associations of the Clan in database and return the state.
        $sql = 'DELETE FROM `clan_team` WHERE `clan_id` = :clan_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);

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
        $sql = 'DELETE FROM `clan_team` WHERE `team_id` = :team_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':team_id', $team->id, \PDO::PARAM_INT);

        return $sth->execute();
    }
}
