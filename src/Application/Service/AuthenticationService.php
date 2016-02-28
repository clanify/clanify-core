<?php
/**
 * Namespace for all Application Services of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Application\Service;

use Clanify\Domain\DataMapper\UserMapper;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Service\SessionService;
use Clanify\Domain\Service\User\HashingService;

/**
 * Class AuthenticationService
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Application\Service
 * @version 0.0.1-dev
 */
class AuthenticationService
{
    /**
     * Method to login an User Entity.
     * @param User $user The User Entity which will be logged in.
     * @return bool The state if the User Entity could be logged in successfully.
     * @since 0.0.1-dev
     */
    public function login(User $user)
    {
        //load the User Entity from database.
        $users = UserRepository::build()->findByUsername($user->username);

        //check if an User Entity could be found.
        if (count($users) === 1) {
            $userDB = $users[0];

            //check if an User is available.
            if ($userDB instanceof User) {

                //hash the input information to compare with the found User Entity.
                $hashingService = new HashingService();
                $user = $hashingService->hashWithSalt($user, $userDB->salt);

                //check if the password match.
                if ($userDB->password === $user->password) {
                    $sessionService = new SessionService();
                    return $sessionService->create($user);
                }
            }
        }

        //return the state.
        return false;
    }

    /**
     * Method to logout an User Entity.
     * @param User $user The User Entity which will be logged out.
     * @return bool The state if the User Entity could be logged out successfully.
     * @since 0.0.1-dev
     */
    public function logout(User $user)
    {
        //delete the session and return the state.
        $sessionService = new SessionService();
        return $sessionService->delete($user);
    }

    /**
     * Method to register an User Entity.
     * @param User $user The User Entity which will be registered.
     * @return bool The state if the User Entity could be registered successfully.
     * @since 0.0.1-dev
     */
    public function register(User $user)
    {
        //get the User Entity with the hashed password information.
        $hashingService = new HashingService();
        $user = $hashingService->hash($user);

        //save the User Entity and return the state.
        return UserMapper::build()->save($user);
    }
}
