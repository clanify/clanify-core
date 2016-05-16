<?php
/**
 * Namespace for testing the Specifications of Team.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\Specification\Team;

use Clanify\Domain\Entity\Team;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\Team\IsValidTeam;

/**
 * Class IsValidTeamTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Team
 * @version 0.0.1-dev
 */
class IsValidTeamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Method to create a valid Team.
     * @return Team A valid Team which can be used to test the Specification.
     * @since 0.0.1-dev
     */
    public function getValidTeam()
    {
        //create and return a valid Team object.
        $team = new Team();
        $team->name = 'Clanify eSport';
        $team->tag = 'CeS';
        $team->website = 'http://clanify.rocks/esport';
        return $team;
    }

    /**
     * Method to test if the Team satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function testIsSatisfiedBy()
    {
        //create the specification.
        $specification = new IsValidTeam();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new User()));

        //test the whole Team.
        $this->assertTrue($specification->isSatisfiedBy($this->getValidTeam()));

        //test the id of the Team.
        $team = $this->getValidTeam();
        $team->id = 'A';
        $this->assertFalse($specification->isSatisfiedBy($team));
        $team->id = -1;
        $this->assertFalse($specification->isSatisfiedBy($team));
        $team->id = 0;
        $this->assertTrue($specification->isSatisfiedBy($team));
        $team->id = 12345;
        $this->asserttrue($specification->isSatisfiedBy($team));

        //test the name of the Team.
        $team = $this->getValidTeam();
        $team->name = '';
        $this->assertFalse($specification->isSatisfiedBy($team));
        $team->name = str_repeat('A', 4);
        $this->assertFalse($specification->isSatisfiedBy($team));
        $team->name = str_repeat('A', 55);
        $this->assertTrue($specification->isSatisfiedBy($team));
        $team->name = str_repeat('A', 101);
        $this->assertFalse($specification->isSatisfiedBy($team));

        //test the tag of the Team.
        $team = $this->getValidTeam();
        $team->tag = '';
        $this->assertFalse($specification->isSatisfiedBy($team));
        $team->tag = str_repeat('A', 1);
        $this->assertFalse($specification->isSatisfiedBy($team));
        $team->tag = str_repeat('A', 3);
        $this->assertTrue($specification->isSatisfiedBy($team));
        $team->tag = str_repeat('A', 6);
        $this->assertFalse($specification->isSatisfiedBy($team));

        //test the website of the Team.
        $team = $this->getValidTeam();
        $team->website = '';
        $this->assertTrue($specification->isSatisfiedBy($team));
        $team->website = 'http://example.com';
        $this->assertTrue($specification->isSatisfiedBy($team));
        $team->website = 'not a valid url';
        $this->assertFalse($specification->isSatisfiedBy($team));
    }
}
