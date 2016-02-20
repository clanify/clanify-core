<?php
/**
 * Namespace for all Specifications of Team.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Team;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Specification\Specification;

/**
 * Class IsValidTag
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 0.0.1-dev
 */
class IsValidTag extends Specification
{
    /**
     * Method to check if the Team satisfies the Specification.
     * @param IEntity $team The Team which will be checked.
     * @return bool The state if the Team satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $team)
    {
        //check if a Team is available.
        if ($team instanceof Team) {

            //check if the tag is valid.
            if (preg_match('/^[A-Za-z0-9]{2,5}$/', $team->tag) > 0) {
                return true;
            }
        }

        //return the state.
        return false;
    }
}
