<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\DataMapper\TeamMapper;
use Clanify\Test\Clanify_DatabaseTestCase;

/**
 * Class TeamMapperTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 1.0.0
 */
class TeamMapperTest extends Clanify_DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     * @since 1.0.0
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/Team/team.xml');
    }

    /**
     * Method to test the create method.
     * @since 1.0.0
     * @test
     */
    public function create()
    {
        //the Team Entity which will be created on database.
        $team = new Team();
        $team->name = 'Example eSport';
        $team->tag = 'EeS';
        $team->website = 'http://example.com';

        //the TeamMapper to create the Team Entity on database.
        $teamMapper = new TeamMapper($this->getConnection()->getConnection());
        $teamMapper->create($team);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('team', 'SELECT * FROM team');
        $expectedDataset = __DIR__.'/DataSets/Team/team-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('team');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);

        //another Entity than Team Entity is not valid on the TeamMapper.
        $this->assertFalse($teamMapper->create(new Clan()));
    }

    /**
     * Method to test the delete method.
     * @since 1.0.0
     * @test
     */
    public function testDelete()
    {
        //the Team Entity which will be deleted on database.
        $team = new Team();
        $team->id = 2;

        //the TeamMapper to delete the Team Entity on database.
        $teamMapper = new TeamMapper($this->getConnection()->getConnection());
        $teamMapper->delete($team);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('team', 'SELECT * FROM team');
        $expectedDataset = __DIR__.'/DataSets/Team/team-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('team');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);

        //another Entity than Team Entity is not valid on the TeamMapper.
        $this->assertFalse($teamMapper->delete(new Clan()));
    }

    /**
     * Method to test the save method.
     * @since 1.0.0
     * @test
     */
    public function testSave()
    {
        //the Team Entity which will be created on database.
        $team_create = new Team();
        $team_create->name = 'Example eSport';
        $team_create->tag = 'EeS';
        $team_create->website = 'http://example.com';

        //the Team Entity which will be updated on database.
        $team_update = new Team();
        $team_update->id = 2;
        $team_update->name = 'Example Team';
        $team_update->tag = 'ET';
        $team_update->website = 'http://example.com/esport';

        //the TeamMapper to save the Team Entity (create) on database.
        $teamMapper = new TeamMapper($this->getConnection()->getConnection());
        $teamMapper->save($team_create);

        //the TeamMapper to save the Team Entity (update) on database.
        $teamMapper = new TeamMapper($this->getConnection()->getConnection());
        $teamMapper->save($team_update);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('team', 'SELECT * FROM team');
        $expectedDataset = __DIR__.'/DataSets/Team/team-save.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('team');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);

        //the Clan Entity which should be fail.
        $clan = new Clan();
        $clan->id = 0;
        $clan->name = 'Example Team';
        $clan->tag = 'ET';

        //another Entity than Team Entity is not valid on the TeamMapper (create).
        $this->assertFalse($teamMapper->save($clan));

        //another Entity than Team Entity is not valid on the TeamMapper (update).
        $clan->id = 1;
        $this->assertFalse($teamMapper->save($clan));
    }

    /**
     * Method to test the update method.
     * @since 1.0.0
     * @test
     */
    public function testUpdate()
    {
        //the Team Entity which will be updated on database.
        $team = new Team();
        $team->id = 2;
        $team->name = 'Example Team';
        $team->tag = 'ET';
        $team->website = 'http://example.com/esport';

        //the TeamMapper to update the Team Entity on database.
        $teamMapper = new TeamMapper($this->getConnection()->getConnection());
        $teamMapper->update($team);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('team', 'SELECT * FROM team');
        $expectedDataset = __DIR__.'/DataSets/Team/team-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('team');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);

        //another Entity than Team Entity is not valid on the TeamMapper.
        $this->assertFalse($teamMapper->update(new Clan()));
    }
}
