<?php
/**
 * Namespace for testing the Specifications of User.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\User;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\User\IsValidPassword;

/**
 * Class IsValidPasswordTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\User
 * @version 1.0.0
 */
class IsValidPasswordTest extends \PHPUnit_Framework_TestCase
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
        $specification = new IsValidPassword();

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Clan()));

        //test the valid User Entity.
        $user = $this->getValidUser();
        $this->assertTrue($specification->isSatisfiedBy($user));

        //the password property have to be at least 8 chars long.
        $user = $this->getValidUser();
        $user->password = str_repeat('A', 7);
        $this->assertFalse($specification->isSatisfiedBy($user));

        //the password property have to be at least 8 chars long.
        $user = $this->getValidUser();
        $user->password = str_repeat('A', 8);
        $this->assertTrue($specification->isSatisfiedBy($user));

        //the password could be more than 300 chars long.
        $user = $this->getValidUser();
        $user->password = str_repeat('A', 301);
        $this->assertTrue($specification->isSatisfiedBy($user));
    }
}
