<?php
/**
 * Namespace for testing the Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Entity;

use Clanify\Domain\Entity\User;

/**
 * Class UserTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Entity
 * @version 1.0.0
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Method to test the loadFromArray method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromArray()
    {
        //create an User Entity.
        $user = new User();

        //the array without prefix to load the User Entity.
        $array = [
            'id' => 1,
            'birthday' => 'Birthday',
            'email' => 'Email',
            'firstname' => 'Firstname',
            'gender' => 'Gender',
            'lastname' => 'Lastname',
            'password' => 'Password',
            'salt' => 'Salt',
            'username' => 'Username'
        ];

        //load the array without prefix to the User Entity.
        $user->loadFromArray($array);

        //check whether the values are valid.
        $this->assertEquals(1, $user->id);
        $this->assertEquals('Birthday', $user->birthday);
        $this->assertEquals('Email', $user->email);
        $this->assertEquals('Firstname', $user->firstname);
        $this->assertEquals('Gender', $user->gender);
        $this->assertEquals('Lastname', $user->lastname);
        $this->assertEquals('Password', $user->password);
        $this->assertEquals('Salt', $user->salt);
        $this->assertEquals('Username', $user->username);

        //the array with prefix to load the User Entity.
        $array_prefix = [
            'test_id' => 2,
            'test_birthday' => 'TestBirthday',
            'test_email' => 'TestEmail',
            'test_firstname' => 'TestFirstname',
            'test_gender' => 'TestGender',
            'test_lastname' => 'TestLastname',
            'test_password' => 'TestPassword',
            'test_salt' => 'TestSalt',
            'test_username' => 'TestUsername'
        ];

        //load the array with prefix to the User Entity.
        $user->loadFromArray($array_prefix, 'test_');

        //check whether the values are valid.
        $this->assertEquals(2, $user->id);
        $this->assertEquals('TestBirthday', $user->birthday);
        $this->assertEquals('TestEmail', $user->email);
        $this->assertEquals('TestFirstname', $user->firstname);
        $this->assertEquals('TestGender', $user->gender);
        $this->assertEquals('TestLastname', $user->lastname);
        $this->assertEquals('TestPassword', $user->password);
        $this->assertEquals('TestSalt', $user->salt);
        $this->assertEquals('TestUsername', $user->username);
    }

    /**
     * Method to test the loadFromObject method.
     * @since 1.0.0
     * @test
     */
    public function testLoadFromObject()
    {
        //create an User Entity.
        $user = new User();

        //the object without prefix to load the User Entity.
        $object = new \stdClass();
        $object->id = 1;
        $object->birthday = 'Birthday';
        $object->email = 'Email';
        $object->firstname = 'Firstname';
        $object->gender = 'Gender';
        $object->lastname = 'Lastname';
        $object->password = 'Password';
        $object->salt = 'Salt';
        $object->username = 'Username';

        //load the object without prefix to the User Entity.
        $user->loadFromObject($object);

        //check whether the values are valid.
        $this->assertEquals(1, $user->id);
        $this->assertEquals('Birthday', $user->birthday);
        $this->assertEquals('Email', $user->email);
        $this->assertEquals('Firstname', $user->firstname);
        $this->assertEquals('Gender', $user->gender);
        $this->assertEquals('Lastname', $user->lastname);
        $this->assertEquals('Password', $user->password);
        $this->assertEquals('Salt', $user->salt);
        $this->assertEquals('Username', $user->username);

        //the object with prefix to load the User Entity.
        $object_prefix = new \stdClass();
        $object_prefix->test_id = 2;
        $object_prefix->test_birthday = 'TestBirthday';
        $object_prefix->test_email = 'TestEmail';
        $object_prefix->test_firstname = 'TestFirstname';
        $object_prefix->test_gender = 'TestGender';
        $object_prefix->test_lastname = 'TestLastname';
        $object_prefix->test_password = 'TestPassword';
        $object_prefix->test_salt = 'TestSalt';
        $object_prefix->test_username = 'TestUsername';

        //load the object with prefix to the User Entity.
        $user->loadFromObject($object_prefix, 'test_');

        //check whether the values are valid.
        $this->assertEquals(2, $user->id);
        $this->assertEquals('TestBirthday', $user->birthday);
        $this->assertEquals('TestEmail', $user->email);
        $this->assertEquals('TestFirstname', $user->firstname);
        $this->assertEquals('TestGender', $user->gender);
        $this->assertEquals('TestLastname', $user->lastname);
        $this->assertEquals('TestPassword', $user->password);
        $this->assertEquals('TestSalt', $user->salt);
        $this->assertEquals('TestUsername', $user->username);
    }
}
