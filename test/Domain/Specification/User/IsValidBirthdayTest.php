<?php
/**
 * Namespace for testing the Specifications of User.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\User;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\User\IsValidBirthday;

/**
 * Class IsValidBithdayTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\User
 * @version 1.0.0
 */
class IsValidBithdayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Method to get a valid User Entity.
     * @return User A valid User Entity which can be used to test the Specification.
     * @since 1.0.0
     */
    private function getValidUser()
    {
        //the salt of the User Entity.
        $salt = '00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c';
        $salt .= '0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc';

        //create the User Entity.
        $user = new User();
        $user->id = 1;
        $user->birthday = '1969-06-27';
        $user->email = 'AlexMHarlow@teleworm.us';
        $user->firstname = 'Alex M.';
        $user->gender = 'M';
        $user->lastname = 'Harlow';
        $user->password = 'Shoghef3pi';
        $user->salt = $salt;
        $user->username = 'Opery1969';
        return $user;
    }

    /**
     * Method to test the isSatisfiedBy method.
     * @since 1.0.0
     * @test
     */
    public function testIsSatisfiedBy()
    {
        //create the Specification.
        $specification = new IsValidBirthday();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Clan()));

        //test the valid User Entity.
        $user = $this->getValidUser();
        $this->assertTrue($specification->isSatisfiedBy($user));

        //the birthday property is optional on the User Entity.
        $user = $this->getValidUser();
        $user->birthday = '';
        $this->assertTrue($specification->isSatisfiedBy($user));

        //the birthday property have to be a valid date.
        $user = $this->getValidUser();
        $user->birthday = 'thisIsNotADate';
        $this->assertFalse($specification->isSatisfiedBy($user));

        //the default value of the birthday is valid.
        $user = $this->getValidUser();
        $user->birthday = '0000-00-00';
        $this->assertTrue($specification->isSatisfiedBy($user));

        //the birthday have to be only a date.
        $user = $this->getValidUser();
        $user->birthday = '2016-01-01HelloWorld';
        $this->assertFalse($specification->isSatisfiedBy($user));

        //incomplete date is invalid.
        $user = $this->getValidUser();
        $user->birthday = '2016-01';
        $this->assertFalse($specification->isSatisfiedBy($user));
    }
}
