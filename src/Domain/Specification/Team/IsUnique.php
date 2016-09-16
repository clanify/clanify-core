<?php
/**
 * Namespace for all Specifications of Team.
 * @since 1.0.0
 */
namespace Clanify\Domain\Specification\Team;

use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Repository\TeamRepository;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class IsUnique
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 1.0.0
 */
class IsUnique implements ISpecification
{
    /**
     * The TeamRepository to use the database.
     * @since 1.0.0
     * @var TeamRepository|null
     */
    private $repository = null;

    /**
     * IsUnique constructor.
     * @param TeamRepository $teamRepository The TeamRepository to use the database.
     * @since 1.0.0
     */
    public function __construct(TeamRepository $teamRepository)
    {
        $this->repository = $teamRepository;
    }

    /**
     * Method to check if the Team satisfies the Specification.
     * @param IEntity $team The Team which will be checked.
     * @return bool The state if the Team satisfies the Specification.
     * @since 1.0.0
     */
    public function isSatisfiedBy(IEntity $team)
    {
        //check if a Team Entity is available.
        if (!($team instanceof Team)) {
            return false;
        }

        //find all Team Entities with the same tag and name (unique properties).
        $teams = $this->repository->findUnique($team->tag, $team->name);

        //check if the Team Entity is unique on database.
        if (($team->id === 0) && (count($teams) > 0)) {
            return false;
        } else {

            //filter all Team Entities with another id.
            $teams = array_filter($teams, function(Team $item) use($team) {
                return $team->id <> $item->id;
            });

            //return the state if a Team Entity is available after filter.
            return (count($teams) === 0);
        }
    }
}
