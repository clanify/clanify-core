<?php
/**
 * Namespace for all TableMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\TableMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Account;
use Clanify\Domain\Entity\User;

/**
 * Class AccountUserTableMapper to persist the association between Account and User.
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\TableMapper
 * @version 1.0.0
 */
class AccountUserTableMapper
{
    /**
     * The PDO database connection.
     * @since 1.0.0
     * @var \PDO|null
     */
    private $pdo = null;

    /**
     * AccountUserTableMapper constructor to initialize the object.
     * @param \PDO $pdo The PDO database connection.
     * @since 1.0.0
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Factory to get a initialized object of the AccountUserTableMapper.
     * @return AccountUserTableMapper The AccountUserTableMapper to persist the association on database.
     * @since 1.0.0
     * @uses Database::getInstance()->getConnection() to get a object of PDO.
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a new association between Account and User.
     * @param Account $account The Account which will be associated with the User.
     * @param User $user The User which will be associated with the Account.
     * @return boolean The state whether the Account could be associated with the User.
     * @since 1.0.0
     */
    public function create(Account $account, User $user)
    {
        //check whether a ID is available on the Account and User.
        if ($account->id <= 0 || $user->id <= 0) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO `account_user` (`account_id`, `user_id`) VALUES (:account_id, :user_id);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':account_id', $account->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        //execute the query and return the state.
        return $sth->execute();
    }

    /**
     * Method to delete the association between a Account and User.
     * @param Account $account The Account of the association with the User which will be removed.
     * @param User $user The User of the association with the Account which will be removed.
     * @return boolean The state whether the association between Account and User could be removed.
     * @since 1.0.0
     */
    public function delete(Account $account, User $user)
    {
        //check whether a ID is available on the Account and User.
        if ($account->id <= 0 || $user->id <= 0) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM `account_user` WHERE `account_id` = :account_id AND `user_id` = :user_id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':account_id', $account->id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        //execute the query and return the state.
        return $sth->execute();
    }

    /**
     * Method to delete all associations of the Account.
     * @param Account $account The Account which associations should be removed.
     * @return boolean The state whether all associations of the Account could be removed.
     * @since 1.0.0
     */
    public function deleteByAccount(Account $account)
    {
        //check whether a ID is available on the Account.
        if ($account->id <= 0) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM `account_user` WHERE `account_id` = :account_id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':account_id', $account->id, \PDO::PARAM_INT);

        //execute the query and return the state.
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

        //create and set the sql query.
        $sql = 'DELETE FROM `account_user` WHERE `user_id` = :user_id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);

        //execute the query and return the state.
        return $sth->execute();
    }
}
