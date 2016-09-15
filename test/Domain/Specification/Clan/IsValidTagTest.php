<?php
/**
 * Namespace for testing the Specifications of Clan.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\Clan\IsValidTag;

/**
 * Class IsValidTagTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Clan
 * @version 1.0.0
 */
class IsValidTagTest extends \PHPUnit_Framework_TestCase
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
        $specification = new IsValidTag();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new User()));

        //test the tag of the Clan Entity.
        $clan = $this->getValidClan();
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //a Clan Entity without a tag is not valid.
        $clan = $this->getValidClan();
        $clan->tag = '';
        $this->assertFalse($specification->isSatisfiedBy($clan));

        //a Clan Entity have to be a tag with a minimum length of 2.
        $clan = $this->getValidClan();
        $clan->tag = str_repeat('A', 1);
        $this->assertFalse($specification->isSatisfiedBy($clan));

        //a Clan Entity with a tag length between 2 and 5 chars is valid.
        $clan = $this->getValidClan();
        $clan->tag = str_repeat('A', 3);
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //a Clan Entity have to be a tag with a maximum length of 5.
        $clan = $this->getValidClan();
        $clan->tag = str_repeat('A', 6);
        $this->assertFalse($specification->isSatisfiedBy($clan));

        //a Clan Entity can only contains numbers.
        $clan = $this->getValidClan();
        $clan->tag = str_repeat('1', 3);
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //a Clan Entity can only contains chars.
        $clan = $this->getValidClan();
        $clan->tag = str_repeat('a', 3);
        $this->assertTrue($specification->isSatisfiedBy($clan));

        //a Clan Entity can contains chars and numbers.
        $clan = $this->getValidClan();
        $clan->tag = 'A1b22';
        $this->assertTrue($specification->isSatisfiedBy($clan));
    }
}
