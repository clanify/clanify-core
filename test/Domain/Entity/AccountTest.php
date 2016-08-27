<?php
/**
 * Namespace for testing the Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Entity;

use Clanify\Domain\Entity\Account;

/**
 * Class AccountTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Entity
 * @version 1.0.0
 */
class AccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Method to test the loadFromArray method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromArray()
    {
        //create an Account Entity.
        $account = new Account();

        //the array without prefix to load the Account Entity.
        $array = [
            'name' => 'Name',
            'value' => 'Value'
        ];

        //load the array without prefix to the Account Entity.
        $account->loadFromArray($array);

        //check whether the values are valid.
        $this->assertEquals('Name', $account->name);
        $this->assertEquals('Value', $account->value);

        //the array with prefix to load the Account Entity.
        $array_prefix = [
            'test_name' => 'TestName',
            'test_value' => 'TestValue'
        ];

        //load the array with prefix to the Account Entity.
        $account->loadFromArray($array_prefix, 'test_');

        //check whether the values are valid.
        $this->assertEquals('TestName', $account->name);
        $this->assertEquals('TestValue', $account->value);
    }

    /**
     * Method to test the loadFromObject method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromObject()
    {
        //create and Account Entity.
        $account = new Account();

        //the object without prefix to load the Account Entity.
        $object = new \stdClass();
        $object->name = 'Name';
        $object->value = 'Value';

        //load the object without prefix to the Account Entity.
        $account->loadFromObject($object);

        //check whether the values are valid.
        $this->assertEquals('Name', $account->name);
        $this->assertEquals('Value', $account->value);

        //the object with prefix to load the Account Entity.
        $object = new \stdClass();
        $object->test_name = 'TestName';
        $object->test_value = 'TestValue';

        //load the object with prefix to the Account Entity.
        $account->loadFromObject($object, 'test_');

        //check whether the values are valid.
        $this->assertEquals('TestName', $account->name);
        $this->assertEquals('TestValue', $account->value);
    }
}
