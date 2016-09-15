<?php
/**
 * Namespace for testing the Specifications of Clan.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\Clan\IsValidWebsite;

/**
 * Class IsValidWebsiteTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Clan
 * @version 1.0.0
 */
class IsValidWebsiteTest extends \PHPUnit_Framework_TestCase
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
        return $clan;
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
        $this->assertFalse($specification->isSatisfiedBy(new User()));

        //test the website of the Clan Entity.
        $clan = $this->getValidClan();
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //the website on Clan Entity is optional.
        $clan = $this->getValidClan();
        $clan->website = '';
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //the website can start with the protocol "http".
        $clan = $this->getValidClan();
        $clan->website = 'http://example.com';
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //the website can start with the protocol "https".
        $clan = $this->getValidClan();
        $clan->website = 'https://example.com';
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //the website should not start with the protocol "ftp".
        $clan = $this->getValidClan();
        $clan->website = 'ftp://example.com';
        $this->assertFalse($specification->isSatisfiedBy($clan));
    }
}
