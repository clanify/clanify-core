<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\Team;
use Clanify\Domain\DataMapper\TeamMapper;
use Clanify\Test\MySQL55Truncate;

/**
 * Class TeamMapperTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 0.0.1-dev
 */
class TeamMapperTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(__DIR__.'/DataSets/Team/team.xml');
    }

    /**
     * Returns the database operation executed in test setup.
     * @return \PHPUnit_Extensions_Database_Operation_IDatabaseOperation
     * @since 0.0.1-dev
     */
    protected function getSetUpOperation()
    {
        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            new MySQL55Truncate(false),
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ));
    }

    /**
     * Method to test if the method delete() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testDelete()
    {
        //The Team which will be deleted on database.
        $team = new Team();
        $team->id = 2;

        //The TeamMapper to delete the Team on database.
        $teamMapper = new TeamMapper($this->pdo);
        $teamMapper->delete($team);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('team', 'SELECT * FROM team');
        $expectedDataSet = __DIR__.'/DataSets/Team/team-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('team');

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
        //The Team which will be created on database.
        $team = new Team();
        $team->name = 'Example eSport';
        $team->tag = 'EeS';
        $team->website = 'http://example.com';

        //The TeamMapper to create the Team on database.
        $teamMapper = new TeamMapper($this->pdo);
        $teamMapper->save($team);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('team', 'SELECT * FROM team');
        $expectedDataSet = __DIR__.'/DataSets/Team/team-save-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('team');

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
        //The Team which will be deleted on database.
        $team = new Team();
        $team->id = 2;
        $team->name = 'Example Team';
        $team->tag = 'ET';
        $team->website = 'http://example.com/esport';

        //The TeamMapper to delete the Team on database.
        $teamMapper = new TeamMapper($this->pdo);
        $teamMapper->save($team);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('team', 'SELECT * FROM team');
        $expectedDataSet = __DIR__.'/DataSets/Team/team-save-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('team');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
