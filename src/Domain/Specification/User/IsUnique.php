<?php
/**
 * Namespace for all Specifications of User.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Specification\Specification;

/**
 * Class IsUnique
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 0.0.1-dev
 */
class IsUnique extends Specification
{
    /**
     * Method to check if the User satisfies the Specification.
     * @param IEntity $user The User which will be checked.
     * @return bool The state if the User satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $user)
    {
        //check if a User is available.
        if ($user instanceof User) {
            $users = UserRepository::build()->findUnique($user->email, $user->username);

            //check if the id should be excluded.
            if ($this->excludeID) {
                return $this->excludeCurrentID($users, $user);
            } else {
                return (count($users) > 0) ? false : true;
            }
        } else {
            return false;
        }
    }
}
