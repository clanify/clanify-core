<?php
/**
 * Namespace for testing the common Specifications of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Common;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Specification\Common\IsValidID;

/**
 * Class IsValidIDTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Common
 * @version 1.0.0
 */
class IsValidIDTest extends \PHPUnit_Framework_TestCase
{
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
        $clan->website = 'http://example.com';
        return $clan;
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
        //create the Specification.
        $specification = new IsValidID();

        //check the ID of the valid Clan Entity.
        $clan = $this->getValidClan();
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //check the ID of the valid Team Entity.
        $team = $this->getValidTeam();
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a not numeric ID is not valid.
        $team = $this->getValidTeam();
        $team->id = 'ABC';
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a mixed ID with numbers and chars is not valid.
        $team = $this->getValidTeam();
        $team->id = 'A1B2C3';
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a numeric ID without chars is valid.
        $team = $this->getValidTeam();
        $team->id = 1234;
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a numeric ID without chars as string is valid.
        $team = $this->getValidTeam();
        $team->id = '1234';
        $this->assertTrue($specification->isSatisfiedBy($team));
    }
}
