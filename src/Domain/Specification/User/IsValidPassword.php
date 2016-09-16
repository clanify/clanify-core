<?php
/**
 * Namespace for all Specifications of User.
 * @since 1.0.0
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class IsValidPassword
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 1.0.0
 */
class IsValidPassword implements ISpecification
{
    /**
     * Method to check if the User satisfies the Specification.
     * @param IEntity $user The User which will be checked.
     * @return bool The state if the User satisfies the Specification.
     * @since 1.0.0
     */
    public function isSatisfiedBy(IEntity $user)
    {
        return (($user instanceof User) && (preg_match('/^[a-zA-Z0-9!?$%&@]{8,}$/', $user->password) === 1));
    }
}
