<?php
/**
 * Namespace for testing the Specifications of Team.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Team;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Specification\Team\IsValidWebsite;

class IsValidWebsiteTest extends \PHPUnit_Framework_TestCase
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
        $specification = new IsValidWebsite();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Clan()));

        //test the website of the Team Entity.
        $team = $this->getValidTeam();
        $this->assertTrue($specification->isSatisfiedBy($team));

        //the website on Team Entity is optional.
        $team = $this->getValidTeam();
        $team->website = '';
        $this->assertTrue($specification->isSatisfiedBy($team));

        //the website can start with the protocol "http".
        $team = $this->getValidTeam();
        $team->website = 'http://example.com';
        $this->assertTrue($specification->isSatisfiedBy($team));

        //the website can start with the protocol "https".
        $team = $this->getValidTeam();
        $team->website = 'https://example.com';
        $this->assertTrue($specification->isSatisfiedBy($team));

        //the website should not start with the protocol "ftp".
        $team = $this->getValidTeam();
        $team->website = 'ftp://example.com';
        $this->assertFalse($specification->isSatisfiedBy($team));
    }
}
