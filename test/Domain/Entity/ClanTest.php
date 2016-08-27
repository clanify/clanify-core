<?php
/**
 * Namespace for testing the Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Entity;

use Clanify\Domain\Entity\Clan;

/**
 * Class ClanTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Entity
 * @version 1.0.0
 */
class ClanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Method to test the loadFromArray method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromArray()
    {
        //create a Clan Entity.
        $clan = new Clan();

        //the array without prefix to load the Clan Entity.
        $array = [
            'id' => 1,
            'name' => 'Name',
            'tag' => 'Tag',
            'website' => 'Website'
        ];

        //load the array without prefix to the Clan Entity.
        $clan->loadFromArray($array);

        //check whether the values are valid.
        $this->assertEquals(1, $clan->id);
        $this->assertEquals('Name', $clan->name);
        $this->assertEquals('Tag', $clan->tag);
        $this->assertEquals('Website', $clan->website);

        //the array with prefix to load the Clan Entity.
        $array_prefix = [
            'test_id' => 2,
            'test_name' => 'TestName',
            'test_tag' => 'TestTag',
            'test_website' => 'TestWebsite'
        ];

        //load the array with prefix to the Clan Entity.
        $clan->loadFromArray($array_prefix, 'test_');

        //check whether the values are valid.
        $this->assertEquals(2, $clan->id);
        $this->assertEquals('TestName', $clan->name);
        $this->assertEquals('TestTag', $clan->tag);
        $this->assertEquals('TestWebsite', $clan->website);
    }

    /**
     * Method to test the loadFromObject method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromObject()
    {
        //create a Clan Entity.
        $clan = new Clan();

        //the object without prefix to load the Clan Entity.
        $object = new \stdClass();
        $object->id = 1;
        $object->name = 'Name';
        $object->tag = 'Tag';
        $object->website = 'Website';

        //load the object without prefix to the Clan Entity.
        $clan->loadFromObject($object);

        //check whether the values are valid.
        $this->assertEquals(1, $clan->id);
        $this->assertEquals('Name', $clan->name);
        $this->assertEquals('Tag', $clan->tag);
        $this->assertEquals('Website', $clan->website);

        //the object with prefix to load the Clan Entity.
        $object_prefix = new \stdClass();
        $object_prefix->test_id = 2;
        $object_prefix->test_name = 'TestName';
        $object_prefix->test_tag = 'TestTag';
        $object_prefix->test_website = 'TestWebsite';

        //load the object with prefix to the Clan Entity.
        $clan->loadFromObject($object_prefix, 'test_');

        //check whether the values are valid.
        $this->assertEquals(2, $clan->id);
        $this->assertEquals('TestName', $clan->name);
        $this->assertEquals('TestTag', $clan->tag);
        $this->assertEquals('TestWebsite', $clan->website);
    }
}
