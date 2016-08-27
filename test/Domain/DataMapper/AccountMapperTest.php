<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\Account;
use Clanify\Domain\DataMapper\AccountMapper;
use Clanify\Test\Clanify_DatabaseTestCase;

/**
 * Class AccountMapperTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 1.0.0
 */
class AccountMapperTest extends Clanify_DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     * @since 1.0.0
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/Account/account.xml');
    }

    /**
     * Method to test the create method.
     * @since 1.0.0
     * @test
     */
    public function testCreate()
    {
        //the Account Entity which will be created on database.
        $account = new Account();
        $account->name = 'STEAM_USERNAME';
        $account->value = 'ExampleUser';

        //the AccountMapper to create the Account Entity on database.
        $accountMapper = new AccountMapper($this->getConnection()->getConnection());
        $accountMapper->create($account);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('account', 'SELECT * FROM account');
        $expectedDataset = __DIR__.'/DataSets/Account/account-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('account');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the delete method.
     * @since 1.0.0
     * @test
     */
    public function testDelete()
    {
        //the Account Entity which will be deleted on database.
        $account = new Account();
        $account->id = 2;

        //the AccountMapper to delete the Account Entity on database.
        $accountMapper = new AccountMapper($this->getConnection()->getConnection());
        $accountMapper->delete($account);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('account', 'SELECT * FROM account');
        $expectedDataset = __DIR__.'/DataSets/Account/account-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('account');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the save method.
     * @since 1.0.0
     * @test
     */
    public function testSave()
    {
        //the Account Entity which will be created on database.
        $account_create = new Account();
        $account_create->name = 'STEAM_USERNAME';
        $account_create->value = 'ExampleUser';

        //the Account Entity which will be updated on database.
        $account_update = new Account();
        $account_update->id = 2;
        $account_update->name = 'BATTLELOG_USERNAME';
        $account_update->value = 'ExampleUser';

        //the AccountMapper to save the Account Entity (create) on database.
        $accountMapper = new AccountMapper($this->getConnection()->getConnection());
        $accountMapper->save($account_create);

        //the AccountMapper to save the Account Entity (update) on database.
        $accountMapper = new AccountMapper($this->getConnection()->getConnection());
        $accountMapper->save($account_update);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('account', 'SELECT * FROM account');
        $expectedDataset = __DIR__.'/DataSets/Account/account-save.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('account');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the update method.
     * @since 1.0.0
     * @test
     */
    public function testUpdate()
    {
        //the Account Entity which will be updated on database.
        $account = new Account();
        $account->id = 2;
        $account->name = 'BATTLELOG_USERNAME';
        $account->value = 'ExampleUser';

        //the AccountMapper to update the Account Entity on database.
        $accountMapper = new AccountMapper($this->getConnection()->getConnection());
        $accountMapper->update($account);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('account', 'SELECT * FROM account');
        $expectedDataset = __DIR__.'/DataSets/Account/account-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('account');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }
}
