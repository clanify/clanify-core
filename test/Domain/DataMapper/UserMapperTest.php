<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\User;
use Clanify\Domain\DataMapper\UserMapper;
use Clanify\Test\Clanify_DatabaseTestCase;

/**
 * Class UserMapperTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 1.0.0
 */
class UserMapperTest extends Clanify_DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     * @since 1.0.0
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/User/user.xml');
    }

    /**
     * Method to test the create method.
     * @since 1.0.0
     * @test
     */
    public function testCreate()
    {
        //the User Entity which will be created on database.
        $user = new User();
        $user->birthday = '1974-08-19';
        $user->email = 'CaseyVWade@dayrep.com';
        $user->firstname = 'Casey V.';
        $user->gender = 'F';
        $user->lastname = 'Wade';
        $user->password = 'athee6aiNg';
        $user->salt = 'd02991c2a8e062a6d419883b6e3a1e58c4090029d1078b58c89c0f096177c379f0552bce705aaf47d7263a70cbf3e527c3662965d62d7cdf34df0053702c50ad';
        $user->username = 'Proothe';

        //the UserMapper to create the User Entity on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userMapper->create($user);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedDataSet = __DIR__.'/DataSets/User/user-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('user');

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
        //the User Entity which will be deleted on database.
        $user = new User();
        $user->id = 2;

        //the UserMapper to delete the User Entity on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userMapper->delete($user);

        //get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedDataSet = __DIR__.'/DataSets/User/user-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('user');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    /**
     * Method to test the save method.
     * @since 1.0.0
     * @test
     */
    public function testSave()
    {
        //the User Entity which will be created on database.
        $user_create = new User();
        $user_create->birthday = '1974-08-19';
        $user_create->email = 'CaseyVWade@dayrep.com';
        $user_create->firstname = 'Casey V.';
        $user_create->gender = 'F';
        $user_create->lastname = 'Wade';
        $user_create->password = 'athee6aiNg';
        $user_create->salt = 'd02991c2a8e062a6d419883b6e3a1e58c4090029d1078b58c89c0f096177c379f0552bce705aaf47d7263a70cbf3e527c3662965d62d7cdf34df0053702c50ad';
        $user_create->username = 'Proothe';

        //the User Entity which will be updated on database.
        $user_update = new User();
        $user_update->id = 2;
        $user_update->birthday = '1996-08-17';
        $user_update->email = 'IdaQGarnes@rhyta.com';
        $user_update->firstname = 'Ida Q.';
        $user_update->gender = 'F';
        $user_update->lastname = 'Garnes';
        $user_update->password = 'Wooch1gei';
        $user_update->salt = 'd02991c2a8e062a6d419883b6e3a1e58c4090029d1078b58c89c0f096177c379f0552bce705aaf47d7263a70cbf3e527c3662965d62d7cdf34df0053702c50ad';
        $user_update->username = 'Stions';

        //the UserMapper to save the User Entity (create) on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userMapper->save($user_create);

        //the UserMapper to save the User Entity (update) on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userMapper->save($user_update);

        //get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedDataSet = __DIR__.'/DataSets/User/user-save.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('user');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    /**
     * Method to test the update method.
     * @since 1.0.0
     * @test
     */
    public function testUpdate()
    {
        //the User Entity which will be updated on database.
        $user = new User();
        $user->id = 2;
        $user->birthday = '1996-08-17';
        $user->email = 'IdaQGarnes@rhyta.com';
        $user->firstname = 'Ida Q.';
        $user->gender = 'F';
        $user->lastname = 'Garnes';
        $user->password = 'Wooch1gei';
        $user->salt = 'd02991c2a8e062a6d419883b6e3a1e58c4090029d1078b58c89c0f096177c379f0552bce705aaf47d7263a70cbf3e527c3662965d62d7cdf34df0053702c50ad';
        $user->username = 'Stions';

        //the UserMapper to update the User Entity on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userMapper->update($user);

        //get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedDataSet = __DIR__.'/DataSets/User/user-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('user');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
