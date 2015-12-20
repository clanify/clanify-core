<?php
/**
 * Namespace for all Specifications of User.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Specification\ISpecification;
use Clanify\Domain\Entity\User;

/**
 * Class IsValidUsername
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 0.0.1-dev
 */
class IsValidUsername implements ISpecification
{
    /**
     * Method to check if the User satisfies the Specification.
     * @param IEntity $user The User which will be checked.
     * @return bool The state if the User satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $user)
    {
        //check if the Entity is a User.
        if ($user instanceof User) {
            return (preg_match('/^[a-zA-Z0-9]{5,100}$/', $user->username) !== 1);
        } else {
            return false;
        }
    }
}
