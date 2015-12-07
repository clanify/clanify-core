<?php
/**
 * Namespace for all Specifications of User.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Domain\Entity\User;

/**
 * Class UsernameIsValid
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 0.0.1-dev
 */
class UsernameIsValid implements IUserSpecification
{
    /**
     * Method to check if the User satisfies the Specification.
     * @param User $user The User which will be checked.
     * @return boolean The state if the User satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(User $user)
    {
        return (preg_match('/^[a-z0-9]{5,}$/', $user->username) !== 1);
    }
}
