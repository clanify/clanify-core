<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\DataMapper\ClanMapper;
use Clanify\Test\MySQL55Truncate;

/**
 * Class ClanMapperTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 0.0.1-dev
 */
class ClanMapperTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(__DIR__.'/DataSets/Clan/clan.xml');
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
        //The Clan which will be deleted on database.
        $clan = new Clan();
        $clan->id = 2;

        //The ClanMapper to delete the Clan on database.
        $clanMapper = new ClanMapper($this->pdo);
        $clanMapper->delete($clan);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataSet = __DIR__.'/DataSets/Clan/clan-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('clan');

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
        //The Clan which will be created on database.
        $clan = new Clan();
        $clan->name = 'Killerbees eSport';
        $clan->tag = 'KBE';
        $clan->website = 'http://example.com/';

        //The ClanMapper to create the Clan on database.
        $clanMapper = new ClanMapper($this->pdo);
        $clanMapper->save($clan);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataSet = __DIR__.'/DataSets/Clan/clan-save-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('clan');

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
        //The Clan which will be updated on database.
        $clan = new Clan();
        $clan->id = 2;
        $clan->name = 'Clanify eSport';
        $clan->tag = 'CeS';
        $clan->website = 'http://clanify.rocks/esport';

        //The ClanMapper to update the Clan on database.
        $clanMapper = new ClanMapper($this->pdo);
        $clanMapper->save($clan);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataSet = __DIR__.'/DataSets/Clan/clan-save-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('clan');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
