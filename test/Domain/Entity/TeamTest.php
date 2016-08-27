<?php
/**
 * Namespace for testing the Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Entity;

use Clanify\Domain\Entity\Team;

/**
 * Class TeamTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Entity
 * @version 1.0.0
 */
class TeamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Method to test the loadFromArray method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromArray()
    {
        //create a Team Entity.
        $team = new Team();

        //the array without prefix to load the Team Entity.
        $array = [
            'id' => 1,
            'name' => 'Name',
            'tag' => 'Tag',
            'website' => 'Website'
        ];

        //load the array without prefix to the Team Entity.
        $team->loadFromArray($array);

        //check whether the values are valid.
        $this->assertEquals(1, $team->id);
        $this->assertEquals('Name', $team->name);
        $this->assertEquals('Tag', $team->tag);
        $this->assertEquals('Website', $team->website);

        //the array with prefix to load the Team Entity.
        $array_prefix = [
            'test_id' => 2,
            'test_name' => 'TestName',
            'test_tag' => 'TestTag',
            'test_website' => 'TestWebsite'
        ];

        //load the array with prefix to the Team Entity.
        $team->loadFromArray($array_prefix, 'test_');

        //check whether the values are valid.
        $this->assertEquals(2, $team->id);
        $this->assertEquals('TestName', $team->name);
        $this->assertEquals('TestTag', $team->tag);
        $this->assertEquals('TestWebsite', $team->website);
    }

    /**
     * Method to test the loadFromObject method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromObject()
    {
        //create a Team Entity.
        $team = new Team();

        //the object without prefix to load the Team Entity.
        $object = new \stdClass();
        $object->id = 1;
        $object->name = 'Name';
        $object->tag = 'Tag';
        $object->website = 'Website';

        //load the object without prefix to the Team Entity.
        $team->loadFromObject($object);

        //check whether the values are valid.
        $this->assertEquals(1, $team->id);
        $this->assertEquals('Name', $team->name);
        $this->assertEquals('Tag', $team->tag);
        $this->assertEquals('Website', $team->website);

        //the object with prefix to load the Team Entity.
        $object_prefix = new \stdClass();
        $object_prefix->test_id = 2;
        $object_prefix->test_name = 'TestName';
        $object_prefix->test_tag = 'TestTag';
        $object_prefix->test_website = 'TestWebsite';

        //load the object with prefix to the Team Entity.
        $team->loadFromObject($object_prefix, 'test_');

        //check whether the values are valid.
        $this->assertEquals(2, $team->id);
        $this->assertEquals('TestName', $team->name);
        $this->assertEquals('TestTag', $team->tag);
        $this->assertEquals('TestWebsite', $team->website);
    }
}
