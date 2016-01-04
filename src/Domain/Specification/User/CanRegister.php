<?php
/**
 * Namespace for all Specifications of User.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Specification\CompositeSpecification;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class CanRegister
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 0.0.1-dev
 */
class CanRegister implements ISpecification
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
            $isValidEmail = new IsValidEmail();
            $isValidPassword = new IsValidPassword();
            $isValidUsername = new IsValidUsername();
            $notExist = new NotExists();
            $isValidSpec = new CompositeSpecification($isValidEmail, $isValidPassword, $isValidUsername, $notExist);

            //check if the User is valid.
            return $isValidSpec->isSatisfiedBy($user);
        } else {
            return false;
        }
    }
}
