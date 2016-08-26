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

        //the array without prefix to load the Account.
        $array = [
            'name' => 'Name',
            'value' => 'Value'
        ];

        //load the array without prefix to the Account.
        $account->loadFromArray($array);

        //test if the values are valid.
        $this->assertEquals('Name', $account->name);
        $this->assertEquals('Value', $account->value);

        //the array with prefix to load the Account.
        $array_prefix = [
            'test_name' => 'TestName',
            'test_value' => 'TestValue'
        ];

        //load the array with prefix to the Account.
        $account->loadFromArray($array_prefix, 'test_');

        //test if the values are valid.
        $this->assertEquals('TestName', $account->name);
        $this->assertEquals('TestValue', $account->value);
    }

    /**
     * Method to test the loadFromArray method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromObject()
    {
        //create and Account Entity.
        $account = new Account();

        //the object without prefix to load the Account.
        $object = new \stdClass();
        $object->name = 'Name';
        $object->value = 'Value';

        //load the object without prefix to the Account.
        $account->loadFromObject($object);

        //test if the values are valid.
        $this->assertEquals('Name', $account->name);
        $this->assertEquals('Value', $account->value);

        //the object with prefix to load the Account.
        $object = new \stdClass();
        $object->test_name = 'TestName';
        $object->test_value = 'TestValue';

        //load the object with prefix to the Account.
        $account->loadFromObject($object, 'test_');

        //test if the values are valid.
        $this->assertEquals('TestName', $account->name);
        $this->assertEquals('TestValue', $account->value);
    }
}
