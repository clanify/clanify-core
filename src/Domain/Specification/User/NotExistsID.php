<?php
/**
 * Namespace for all Specifications of User.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Core\Database;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Specification\Specification;

/**
 * Class NotExistsID
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 0.0.1-dev
 */
class NotExistsID extends Specification
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
            $database = Database::getInstance();
            $userRepository = new UserRepository($database->getConnection());

            //find the Users by id.
            $users = $userRepository->findByID($user->id);

            //check if a User was found and return the state.
            return (count($users) > 0) ? false : true;
        } else {
            return false;
        }
    }
}
