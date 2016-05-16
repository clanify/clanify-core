<?php
/**
 * Namespace for testing the Specifications of Clan.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\Clan\IsValidName;

/**
 * Class IsValidNameTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Clan
 * @version 0.0.1-dev
 */
class IsValidNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Method to get a valid Clan Entity.
     * @return Clan A valid Clan Entity which can be used to test the Specification.
     * @since 0.0.1-dev
     */
    public function getValidClan()
    {
        //create and return a valid Clan Entity.
        $clan = new Clan();
        $clan->name = 'Clanify';
        $clan->tag = 'CFY';
        $clan->website = 'http://clanify.rocks';
        return $clan;
    }

    /**
     * Method to test if the Clan satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function testIsSatisfiedBy()
    {
        //create the specification.
        $specification = new IsValidName();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new User()));

        //test the name of the Clan Entity.
        $clan = $this->getValidClan();
        $clan->name = '';
        $this->assertFalse($specification->isSatisfiedBy($clan));
        $clan->name = str_repeat('A', 4);
        $this->assertFalse($specification->isSatisfiedBy($clan));
        $clan->name = str_repeat('A', 55);
        $this->assertTrue($specification->isSatisfiedBy($clan));
        $clan->name = str_repeat('A', 101);
        $this->assertFalse($specification->isSatisfiedBy($clan));
    }
}
