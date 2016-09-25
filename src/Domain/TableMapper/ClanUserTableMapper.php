<?php
/**
 * Namespace for all TableMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\TableMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;

/**
 * TableMapper to persist the association between Clan and User.
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\TableMapper
 * @version 1.0.0
 */
class ClanUserTableMapper extends TableMapper
{
    /**
     * Factory to get a initialized object of the ClanUserTableMapper.
     * @return ClanUserTableMapper The ClanUserTableMapper to persist the association on database.
     * @since 1.0.0
     * @uses Database::getInstance()->getConnection() to get a object of PDO.
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a new association between Clan and User.
     * @param Clan $clan The Clan which will be associated with the User.
     * @param User $user The User which will be associated with the Clan.
     * @return boolean The state whether the Clan could be associated with the User.
     * @since 1.0.0
     */
    public function create(Clan $clan, User $user)
    {
        //check whether a ID is available on the Clan and User.
        if ($clan->id <= 0 || $user->id <= 0) {
            return false;
        }

        //create the association in database and return the state.
        $sql = 'INSERT INTO `clan_user` (`clan_id`, `user_id`) VALUES (:clan_id, :user_id);';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    /**
     * Method to delete the association between a Clan and User.
     * @param Clan $clan The Clan of the association with the User which will be removed.
     * @param User $user The User of the association with the Clan which will be removed.
     * @return boolean The state whether the association between Clan and User could be removed.
     * @since 1.0.0
     */
    public function delete(Clan $clan, User $user)
    {
        //check whether a ID is available on the Clan and User.
        if ($clan->id <= 0 || $user->id <= 0) {
            return false;
        }

        //delete the association in database and return the state.
        $sql = 'DELETE FROM `clan_user` WHERE `clan_id` = :clan_id AND `user_id` = :user_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

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
        $sql = 'DELETE FROM `clan_user` WHERE `clan_id` = :clan_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':clan_id', $clan->id, \PDO::PARAM_INT);

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
        $sql = 'DELETE FROM `clan_user` WHERE `user_id` = :user_id;';
        $sth = $this->pdo->prepare($sql);

        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        return $sth->execute();
    }
}
