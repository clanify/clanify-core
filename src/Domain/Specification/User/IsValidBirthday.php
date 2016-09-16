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
 * Class IsValidBirthday
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 1.0.0
 */
class IsValidBirthday implements ISpecification
{
    /**
     * Method to check if the User satisfies the Specification.
     * @param IEntity $user The User which will be checked.
     * @return bool The state if the User satisfies the Specification.
     * @since 1.0.0
     */
    public function isSatisfiedBy(IEntity $user)
    {
        //check if a User Entity is available.
        if (!($user instanceof User)) {
            return false;
        }

        //check if a default value is available.
        if (($user->birthday === '0000-00-00') || ($user->birthday === '')) {
            return true;
        }

        //check if only valid chars available.
        if (preg_match('/^[0-9\-]{0,10}$/', $user->birthday) !== 1) {
            return false;
        }

        //explode the date into the date parts.
        $date = explode('-', $user->birthday);

        //check if the three parts of the date are available.
        if (count($date) === 3) {
            return checkdate($date[1], $date[2], $date[0]);
        } else {
            return false;
        }
    }
}
