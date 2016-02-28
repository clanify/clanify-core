<?php
/**
 * Namespace for all Domain Services of User.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Service\User;

use Clanify\Domain\Entity\User;

/**
 * Class HashingService
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Service
 * @version 0.0.1-dev
 */
class HashingService
{
    /**
     * Method to hash the password information of an User Entity.
     * @param User $user The User Entity which should get hashed password information.
     * @return User The User Entity with the hashed password information.
     * @since 0.0.1-dev
     */
    public function hash(User $user)
    {
        //create and set the hashed password information to the User.
        $user->salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $user->password = hash('sha512', $user->password . $user->salt);

        //return the User Entity with the hashed password information.
        return $user;
    }

    /**
     * Method to hash the password information of an User Entity with specified salt.
     * @param User $user The User Entity which should get hashed password information.
     * @param string $salt The specified hash which will be used to create the hashed password information.
     * @return User The User Entity with the hashed password information.
     * @since 0.0.1-dev
     */
    public function hashWithSalt(User $user, $salt)
    {
        //create and set the hashed password information to the User.
        $user->salt = $salt;
        $user->password = hash('sha512', $user->password . $user->salt);

        //return the User Entity with the hashed password information.
        return $user;
    }
}
