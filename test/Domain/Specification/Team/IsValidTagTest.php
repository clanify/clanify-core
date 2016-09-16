<?php
/**
 * Namespace for testing the Specifications of Team.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Team;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Specification\Team\IsValidTag;

/**
 * Class IsValidTagTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Team
 * @version 1.0.0
 */
class IsValidTagTest extends \PHPUnit_Framework_TestCase
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
        $specification = new IsValidTag();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Clan()));

        //test the tag of the Team Entity.
        $team = $this->getValidTeam();
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a Team Entity without a tag is not valid.
        $team = $this->getValidTeam();
        $team->tag = '';
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a Team Entity have to be a tag with a minimum length of 2.
        $team = $this->getValidTeam();
        $team->tag = str_repeat('A', 1);
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a Team Entity with a tag length between 2 and 5 chars is valid.
        $team = $this->getValidTeam();
        $team->tag = str_repeat('A', 3);
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a Team Entity have to be a tag with a maximum length of 5.
        $team = $this->getValidTeam();
        $team->tag = str_repeat('A', 6);
        $this->assertFalse($specification->isSatisfiedBy($team));

        //a Team Entity can only contains numbers.
        $team = $this->getValidTeam();
        $team->tag = str_repeat('1', 3);
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a Team Entity can only contains chars.
        $team = $this->getValidTeam();
        $team->tag = str_repeat('a', 3);
        $this->assertTrue($specification->isSatisfiedBy($team));

        //a Team Entity can contains chars and numbers.
        $team = $this->getValidTeam();
        $team->tag = 'A1b22';
        $this->assertTrue($specification->isSatisfiedBy($team));
    }
}
