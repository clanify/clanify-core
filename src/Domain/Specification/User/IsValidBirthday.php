<?php
/**
 * Namespace for all Specifications of User.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\Specification;

/**
 * Class IsValidBirthday
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 0.0.1-dev
 */
class IsValidBirthday extends Specification
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

            //check if a default value is available.
            if (($user->birthday === '0000-00-00') || ($user->birthday === '')) {
                return true;
            } else {
                $date = explode('-', $user->birthday);
                return checkdate($date[1], $date[2], $date[0]);
            }
        } else {
            return false;
        }
    }
}
