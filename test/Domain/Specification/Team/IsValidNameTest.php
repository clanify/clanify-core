<?php
/**
 * Namespace for testing the Specifications of Team.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Team;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Specification\Team\IsValidName;

/**
 * Class IsValidNameTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Team
 * @version 1.0.0
 */
class IsValidNameTest extends \PHPUnit_Framework_TestCase
{
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
        $specification = new IsValidName();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Clan()));

        //test the name of the Team Entity.
        $team = $this->getValidTeam();
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a Team Entity without name is not valid.
        $team = $this->getValidTeam();
        $team->name = '';
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a Team Entity have to be a name with a minimum length of 5 chars.
        $team = $this->getValidTeam();
        $team->name = str_repeat('A', 4);
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a Team Entity with a name length between 5 and 100 chars is valid.
        $team = $this->getValidTeam();
        $team->name = str_repeat('A', 55);
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a Team Entity have to be a name with a maximum length of 100 chars.
        $team = $this->getValidTeam();
        $team->name = str_repeat('A', 101);
        $this->assertFalse($specification->isSatisfiedBy($team));
    }
}
