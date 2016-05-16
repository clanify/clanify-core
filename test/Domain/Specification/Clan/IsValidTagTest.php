<?php
/**
 * Namespace for testing the Specifications of Clan.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\Clan\IsValidTag;

/**
 * Class IsValidTagTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\Clan
 * @version 0.0.1-dev
 */
class IsValidTagTest extends \PHPUnit_Framework_TestCase
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
        $specification = new IsValidTag();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new User()));

        //test the tag of the Clan Entity.
        $clan = $this->getValidClan();
        $clan->tag = '';
        $this->assertFalse($specification->isSatisfiedBy($clan));
        $clan->tag = str_repeat('A', 1);
        $this->assertFalse($specification->isSatisfiedBy($clan));
        $clan->tag = str_repeat('A', 3);
        $this->assertTrue($specification->isSatisfiedBy($clan));
        $clan->tag = str_repeat('A', 6);
        $this->assertFalse($specification->isSatisfiedBy($clan));
        $clan->tag = str_repeat('1', 3);
        $this->assertTrue($specification->isSatisfiedBy($clan));
        $clan->tag = str_repeat('a', 3);
        $this->assertTrue($specification->isSatisfiedBy($clan));
        $clan->tag = 'A1b22';
        $this->assertTrue($specification->isSatisfiedBy($clan));
    }
}
