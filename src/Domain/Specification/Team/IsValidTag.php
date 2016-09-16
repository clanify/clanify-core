<?php
/**
 * Namespace for all Specifications of Team.
 * @since 1.0.0
 */
namespace Clanify\Domain\Specification\Team;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class IsValidTag
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 1.0.0
 */
class IsValidTag implements ISpecification
{
    /**
     * Method to check if the Team satisfies the Specification.
     * @param IEntity $team The Team which will be checked.
     * @return bool The state if the Team satisfies the Specification.
     * @since 1.0.0
     */
    public function isSatisfiedBy(IEntity $team)
    {
        return (($team instanceof Team) && (preg_match('/^[A-Za-z0-9]{2,5}$/', $team->tag)) === 1);
    }
}
