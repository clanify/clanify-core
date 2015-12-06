<?php
/**
 * Namespace for all Specifications of Team.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Team;

use Clanify\Domain\Entity\Team;

/**
 * Interface ITeamSpecification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 0.0.1-dev
 */
interface ITeamSpecification
{
    /**
     * Method to check if the Team satisfies the Specification.
     * @param Team $team The Team which will be checked.
     * @return boolean The state if the Team satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(Team $team);
}
