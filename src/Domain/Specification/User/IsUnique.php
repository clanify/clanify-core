<?php
/**
 * Namespace for all Specifications of User.
 * @since 1.0.0
 */
namespace Clanify\Domain\Specification\User;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class IsUnique
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\User
 * @version 1.0.0
 */
class IsUnique implements ISpecification
{
    /**
     * The UserRepository to use the database.
     * @since 1.0.0
     * @var UserRepository|null
     */
    private $repository = null;

    /**
     * IsUnique constructor.
     * @param UserRepository $userRepository The UserRepository to use the database.
     * @since 1.0.0
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

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

        //find all User Entities with the same email and username (unique properties).
        $users = $this->repository->findUnique($user->email, $user->username);

        //check if the User Entity is unique on database.
        if (($user->id === 0) && (count($users) > 0)) {
            return false;
        } else {

            //filter all User Entities with another ID.
            $users = array_filter($users, function(User $item) use($user) {
                return $user->id <> $item->id;
            });

            //return the state if a User Entity is available after filter.
            return (count($users) === 0);
        }
    }
}
