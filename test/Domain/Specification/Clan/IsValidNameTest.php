<?php
/**
 * Namespace for testing the Specifications of Clan.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\Clan\IsValidName;

/**
 * Class IsValidNameTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Clan
 * @version 1.0.0
 */
class IsValidNameTest extends \PHPUnit_Framework_TestCase
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
     * Method to test the isSatisfiedBy method.
     * @since 1.0.0
     * @test
     */
    public function testIsSatisfiedBy()
    {
        //create the Specification.
        $specification = new IsValidName();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new User()));

        //test the name of the Clan Entity.
        $clan = $this->getValidClan();
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //a Clan Entity without name is not valid.
        $clan = $this->getValidClan();
        $clan->name = '';
        $this->assertFalse($specification->isSatisfiedBy($clan));

        //a Clan Entity have to be a name with a minimum length of 5 chars.
        $clan = $this->getValidClan();
        $clan->name = str_repeat('A', 4);
        $this->assertFalse($specification->isSatisfiedBy($clan));

        //a Clan Entity with a name length between 5 and 100 chars is valid.
        $clan = $this->getValidClan();
        $clan->name = str_repeat('A', 55);
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //a Clan Entity have to be a name with a maximum length of 100 chars.
        $clan = $this->getValidClan();
        $clan->name = str_repeat('A', 101);
        $this->assertFalse($specification->isSatisfiedBy($clan));
    }
}
