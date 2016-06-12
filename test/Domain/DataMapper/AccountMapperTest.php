<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\Account;
use Clanify\Test\MySQL55Truncate;
use Clanify\Domain\DataMapper\AccountMapper;

/**
 * Class ClanMapperTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 0.0.1-dev
 */
class AccountMapperTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * The database connection with PDO.
     * @since 0.0.1-dev
     * @var null|\PDO
     */
    private $pdo = null;

    /**
     * Method to get the database connection for test.
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     * @since 0.0.1-dev
     */
    public function getConnection()
    {
        //get the database information.
        $dsn = getenv('DB_DSN');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWD');
        $database = getenv('DB_DBNAME');

        //create the database connection.
        $this->pdo = new \PDO($dsn, $user, $password);
        return $this->createDefaultDBConnection($this->pdo, $database);
    }

    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     * @since 0.0.1-dev
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/Account/account.xml');
    }

    /**
     * Returns the database operation executed in test setup.
     * @return \PHPUnit_Extensions_Database_Operation_IDatabaseOperation The database operation.
     * @since 0.0.1-dev
     */
    protected function getSetUpOperation()
    {
        //create the parameters for composite.
        $truncate = new MySQL55Truncate(false);
        $factoryInsert = \PHPUnit_Extensions_Database_Operation_Factory::INSERT();

        //create and return the database operation.
        return new \PHPUnit_Extensions_Database_Operation_Composite(array($truncate, $factoryInsert));
    }

    /**
     * Method to test if the method delete() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testDelete()
    {
        //The Account which will be deleted on database.
        $account = new Account();
        $account->id = 2;

        //The AccountMapper to delete the Account on database.
        $accountMapper = new AccountMapper($this->pdo);
        $accountMapper->delete($account);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('account', 'SELECT * FROM account');
        $expectedDataSet = __DIR__.'/DataSets/Account/account-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('account');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    /**
     * Method to test if the method create() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testSaveCreate()
    {
        //The Account which will be created on database.
        $account = new Account();
        $account->game = 'BATTLELOG_USERNAME';
        $account->value = 'ExampleUser';

        //The AccountMapper to create the Account on database.
        $accountMapper = new AccountMapper($this->pdo);
        $accountMapper->save($account);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('account', 'SELECT * FROM account');
        $expectedDataSet = __DIR__.'/DataSets/Account/account-save-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('account');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    /**
     * Method to test if the method update() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testSaveUpdate()
    {
        //The Account which will be updated on database.
        $account = new Account();
        $account->id = 2;
        $account->game = 'STEAM_USERNAME';
        $account->value = 'ExampleUser';

        //The AccountMapper to update the Account on database.
        $accountMapper = new AccountMapper($this->pdo);
        $accountMapper->save($account);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('account', 'SELECT * FROM account');
        $expectedDataSet = __DIR__.'/DataSets/Account/account-save-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('account');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
