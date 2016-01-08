<?php
/**
 * Namespace for all Specifications of Team.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Team;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Specification\CompositeSpecification;
use Clanify\Domain\Specification\Specification;

/**
 * Class CanCreate
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 0.0.1-dev
 */
class CanCreate extends Specification
{
    /**
     * Method to check if the Team satisfies the Specification.
     * @param IEntity $team The Team which will be checked.
     * @return bool The state if the Team satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $team)
    {
        //check if the Entity is a Team.
        if ($team instanceof Team) {

            //create the composite specification.
            $validSpec = new CompositeSpecification(
                new IsValidName(),
                new IsValidTag(),
                new IsValidWebsite(),
                new NotExistsName(),
                new NotExistsTag()
            );

            //check if the Team is valid.
            return $validSpec->isSatisfiedBy($team);
        } else {
            return false;
        }
    }
}
