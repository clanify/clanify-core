<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\User;
use Clanify\Domain\DataMapper\UserMapper;

/**
 * Class UserMapperTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 0.0.1-dev
 */
class UserMapperTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(__DIR__.'/DataSets/User/user.xml');
    }

    /**
     * Returns the database operation executed in test setup.
     * @return \PHPUnit_Extensions_Database_Operation_IDatabaseOperation
     * @since 0.0.1-dev
     */
    protected function getSetUpOperation()
    {
        return \PHPUnit_Extensions_Database_Operation_Factory::CLEAN_INSERT(true);
    }

    /**
     * Performs operation returned by getSetUpOperation().
     * @since 0.0.1-dev
     */
    public function setUp()
    {
        $connection = $this->getConnection();
        $connection->getConnection()->query("SET FOREIGN_KEY_CHECKS=0");
        parent::setUp();
        $connection->getConnection()->query("SET FOREIGN_KEY_CHECKS=1");
    }

    /**
     * Method to test if the method delete() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testDelete()
    {
        //The User which will be deleted on database.
        $user = new User();
        $user->id = 2;

        //The UserMapper to delete the User on database.
        $userMapper = new UserMapper($this->pdo);
        $userMapper->delete($user);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedDataSet = __DIR__.'/DataSets/User/user-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('user');

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
        //The User which will be created on database.
        $user = new User();
        $user->birthday = '1974-08-19';
        $user->email = 'CaseyVWade@dayrep.com';
        $user->firstname = 'Casey V.';
        $user->gender = 'F';
        $user->lastname = 'Wade';
        $user->password = 'athee6aiNg';
        $user->salt = 'd02991c2a8e062a6d419883b6e3a1e58c4090029d1078b58c89c0f096177c379f0552bce705aaf47d7263a70cbf3e527c3662965d62d7cdf34df0053702c50ad';
        $user->username = 'Proothe';

        //The UserMapper to create the User on database.
        $userMapper = new UserMapper($this->pdo);
        $userMapper->save($user);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedDataSet = __DIR__.'/DataSets/User/user-save-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('user');

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
        //The User which will be updated on database.
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

        //The UserMapper to update the User on database.
        $userMapper = new UserMapper($this->pdo);
        $userMapper->save($user);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedDataSet = __DIR__.'/DataSets/User/user-save-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('user');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
