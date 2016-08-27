<?php
/**
 * Namespace for testing the DataMapper of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\DataMapper\ClanMapper;
use Clanify\Test\Clanify_DatabaseTestCase;

/**
 * Class ClanMapperTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 1.0.0
 */
class ClanMapperTest extends Clanify_DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     * @since 1.0.0
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/Clan/clan.xml');
    }

    /**
     * Method to test the create method.
     * @since 1.0.0
     * @test
     */
    public function testCreate()
    {
        //the Clan Entity which will be created on database.
        $clan = new Clan();
        $clan->name = 'Killerbees eSport';
        $clan->tag = 'KBE';
        $clan->website = 'http://example.com/';

        //the ClanMapper to create the Clan Entity on database.
        $clanMapper = new ClanMapper($this->getConnection()->getConnection());
        $clanMapper->create($clan);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataset = __DIR__.'/DataSets/Clan/clan-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('clan');

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
        //the Clan Entity which will be deleted on database.
        $clan = new Clan();
        $clan->id = 2;

        //the ClanMapper to delete the Clan Entity on database.
        $clanMapper = new ClanMapper($this->getConnection()->getConnection());
        $clanMapper->delete($clan);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataset = __DIR__.'/DataSets/Clan/clan-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('clan');

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
        //the Clan Entity which will be created on database.
        $clan_create = new Clan();
        $clan_create->name = 'Killerbees eSport';
        $clan_create->tag = 'KBE';
        $clan_create->website = 'http://example.com/';

        //the Clan Entity which will be updated on database.
        $clan_update = new Clan();
        $clan_update->id = 2;
        $clan_update->name = 'Clanify Gaming';
        $clan_update->tag = 'CG';
        $clan_update->website = 'http://clanify.rocks/gaming';

        //the ClanMapper to save the Clan Entity (create) on database.
        $clanMapper = new ClanMapper($this->getConnection()->getConnection());
        $clanMapper->save($clan_create);

        //the ClanMapper to save the Clan Entity (update) on database.
        $clanMapper = new ClanMapper($this->getConnection()->getConnection());
        $clanMapper->save($clan_update);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataset = __DIR__.'/DataSets/Clan/clan-save.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('clan');

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
        //the Clan Entity which will be updated on database.
        $clan = new Clan();
        $clan->id = 2;
        $clan->name = 'Clanify Gaming';
        $clan->tag = 'CG';
        $clan->website = 'http://clanify.rocks/gaming';

        //the ClanMapper to update the Clan Entity on database.
        $clanMapper = new ClanMapper($this->getConnection()->getConnection());
        $clanMapper->update($clan);

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataset = __DIR__.'/DataSets/Clan/clan-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('clan');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }
}
