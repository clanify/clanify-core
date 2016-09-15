<?php
/**
 * Namespace for testing the Specifications of Clan.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Clan;

use Clanify\Domain\DataMapper\ClanMapper;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Repository\ClanRepository;
use Clanify\Domain\Specification\Clan\IsUnique;
use Clanify\Test\Clanify_DatabaseTestCase;

/**
 * Class IsUniqueTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Clan
 * @version 1.0.0
 */
class IsUniqueTest extends Clanify_DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet The DataSet which includes the test records.
     * @since 1.0.0
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/clan.xml');
    }

    /**
     * Method to get a valid Clan Entity.
     * @return Clan A valid Clan Entity which can be used to test the Specification.
     * @since 1.0.0
     */
    private function getValidClan()
    {
        $clan = new Clan();
        $clan->id = 1;
        $clan->name = 'Example Gaming';
        $clan->tag = 'EG';
        return $clan;
    }

    /**
     * Method to test the isSatisfiedBy method.
     * @since 1.0.0
     * @test
     */
    public function testIsSatisfiedBy()
    {
        //create a ClanMapper and ClanRepository.
        $dataMapper = new ClanMapper($this->getConnection()->getConnection());
        $clanRepository = new ClanRepository($dataMapper);

        //create the Specification.
        $specification = new IsUnique($clanRepository);

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Team()));

        //test the uniqueness of the Clan Entity.
        $clan = $this->getValidClan();
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //with another ID the Clan Entity is not unique.
        $clan = $this->getValidClan();
        $clan->id = 2;
        $this->assertFalse($specification->isSatisfiedBy($clan));

        //a new Clan Entity (ID = 0) with the same information is not unique.
        $clan = $this->getValidClan();
        $clan->id = 0;
        $this->assertFalse($specification->isSatisfiedBy($clan));

        //a Clan Entity with another tag is unique.
        $clan = $this->getValidClan();
        $clan->tag = 'FG';
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //a Clan Entity with another name is unique.
        $clan = $this->getValidClan();
        $clan->name = 'Example Gaming 2';
        $this->assertTrue($specification->isSatisfiedBy($clan));
    }
}
