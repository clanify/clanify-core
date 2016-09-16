<?php
/**
 * Namespace for testing the Specifications of Team.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Team;

use Clanify\Domain\DataMapper\TeamMapper;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Repository\TeamRepository;
use Clanify\Domain\Specification\Team\IsUnique;
use Clanify\Test\Clanify_DatabaseTestCase;

/**
 * Class IsUniqueTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Team
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
        return $this->createXMLDataSet(__DIR__.'/DataSets/team.xml');
    }

    /**
     * Method to get a valid Team Entity.
     * @return Team A valid Team Entity which can be used to test the Specification.
     * @since 1.0.0
     */
    private function getValidTeam()
    {
        $team = new Team();
        $team->id = 1;
        $team->name = 'Killerbees eSport';
        $team->tag = 'KBE';
        $team->website = 'http://example.com';
        return $team;
    }

    /**
     * Method to test the isSatisfiedBy method.
     * @since 1.0.0
     * @test
     */
    public function testIsSatisfiedBy()
    {
        //create a TeamMapper and TeamRepository.
        $dataMapper = new TeamMapper($this->getConnection()->getConnection());
        $teamRepository = new TeamRepository($dataMapper);

        //create the Specification.
        $specification = new IsUnique($teamRepository);

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Clan()));

        //test the uniqueness of the Team Entity.
        $team = $this->getValidTeam();
        $this->assertTrue($specification->isSatisfiedBy($team));

        //with another ID the Team Entity is not unique.
        $team = $this->getValidTeam();
        $team->id = 2;
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a new Team Entity (ID = 0) with the same information is not unique.
        $team = $this->getValidTeam();
        $team->id = 0;
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a Team Entity with another tag is unique.
        $team = $this->getValidTeam();
        $team->tag = 'FG';
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a Team Entity with another name is unique.
        $team = $this->getValidTeam();
        $team->name = 'Example Gaming 2';
        $this->assertTrue($specification->isSatisfiedBy($team));
    }
}
