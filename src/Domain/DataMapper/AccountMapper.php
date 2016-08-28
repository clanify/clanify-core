<?php
/**
 * Namespace for all DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\DataMapper;

use Clanify\Core\Database;
use Clanify\Domain\Entity\Account;
use Clanify\Domain\Entity\IEntity;

/**
 * Class AccountMapper
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\DataMapper
 * @version 1.0.0
 */
class AccountMapper extends DataMapper
{
    /**
     * AccountMapper constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 1.0.0
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'account';
        $this->pdo = $pdo;
    }

    /**
     * Method to build a new object of AccountMapper.
     * @return AccountMapper The created object of AccountMapper.
     * @since 1.0.0
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create an Account on database.
     * @param IEntity $account The Account Entity.
     * @return bool The state if the Account Entity was successfully created.
     * @since 1.0.0
     */
    public function create(IEntity $account)
    {
        //check if an Account is available.
        if (!($account instanceof Account)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (name, value) VALUES (:name, :value);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':name', $account->name, \PDO::PARAM_STR);
        $sth->bindParam(':value', $account->value, \PDO::PARAM_STR);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to delete an Account on database.
     * @param IEntity $account The Account Entity.
     * @return bool The state if the Account Entity was successfully deleted.
     * @since 1.0.0
     */
    public function delete(IEntity $account)
    {
        //check if an Account is available.
        if (!($account instanceof Account)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $account->id, \PDO::PARAM_INT);

        //execute the query and return state.
        return $sth->execute();
    }

    /**
     * Method to find Account Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Account Entities.
     * @return array An array with all found Account Entities.
     * @since 1.0.0
     */
    public function find($condition = '')
    {
        return $this->findForEntity($condition, new Account());
    }

    /**
     * Method to save an Account on database.
     * @param IEntity $account The Account Entity.
     * @return bool The state if the Account Entity was successfully saved.
     * @since 1.0.0
     */
    public function save(IEntity $account)
    {
        //check if an Account is available.
        if (!($account instanceof Account)) {
            return false;
        }

        //create or update the Account.
        return ($account->id > 0) ? $this->update($account) : $this->create($account);
    }

    /**
     * Method to update an Account on database.
     * @param IEntity $account The Account Entity.
     * @return bool The state if the Account Entity was successfully updated.
     * @since 1.0.0
     */
    public function update(IEntity $account)
    {
        //check if an Account is available.
        if (!($account instanceof Account)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET name = :name, value = :value WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $account->id, \PDO::PARAM_INT);
        $sth->bindParam(':name', $account->name, \PDO::PARAM_STR);
        $sth->bindParam(':value', $account->value, \PDO::PARAM_STR);

        //execute the query and return the state.
        return $sth->execute();
    }
}
