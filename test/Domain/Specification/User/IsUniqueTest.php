<?php
/**
 * Namespace for testing the Specifications of User.
 * @since 1.0.0
 */
namespace Clanify\Test\Domain\Specification\User;

use Clanify\Domain\DataMapper\UserMapper;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Specification\User\IsUnique;
use Clanify\Test\Clanify_DatabaseTestCase;

/**
 * Class IsUniqueTest
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\Specification\User
 * @version 1.0.0
 */
class IsUniqueTest extends Clanify_DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet The DataSet which includes the test records.
     * @since 1.0.0
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/user.xml');
    }

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
        //create a UserMapper and UserRepository.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userRepository = new UserRepository($userMapper);

        //create the Specification.
        $specification = new IsUnique($userRepository);

        //test another Entity.
        $this->assertFalse($specification->isSatisfiedBy(new Clan()));

        //test the uniqueness of the User Entity.
        $user = $this->getValidUser();
        $this->assertTrue($specification->isSatisfiedBy($user));

        //with another ID the User Entity is not unique.
        $user = $this->getValidUser();
        $user->id = 2;
        $this->assertFalse($specification->isSatisfiedBy($user));

        //a new User Entity (ID = 0) with the same information is not unique.
        $user = $this->getValidUser();
        $user->id = 0;
        $this->assertFalse($specification->isSatisfiedBy($user));

        //a User Entity with another username is unique.
        $user = $this->getValidUser();
        $user->username = 'Proothe';
        $this->assertTrue($specification->isSatisfiedBy($user));

        //a User Entity with another email is unique.
        $user = $this->getValidUser();
        $user->email = 'CaseyVWade@dayrep.com';
        $this->assertTrue($specification->isSatisfiedBy($user));
    }
}
