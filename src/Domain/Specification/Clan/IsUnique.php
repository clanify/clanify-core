<?php
/**
 * Namespace for all Specifications of Clan.
 * @since 1.0.0
 */
namespace Clanify\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Repository\ClanRepository;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class IsUnique
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Clan
 * @version 1.0.0
 */
class IsUnique implements ISpecification
{
    /**
     * The ClanRepository to use the database.
     * @since 1.0.0
     * @var ClanRepository|null
     */
    private $repository = null;

    /**
     * IsUnique constructor.
     * @param ClanRepository $clanRepository The ClanRepository to use the database.
     * @since 1.0.0
     */
    public function __construct(ClanRepository $clanRepository)
    {
        $this->repository = $clanRepository;
    }

    /**
     * Method to check if the Clan satisfies the Specification.
     * @param IEntity $clan The Clan which will be checked.
     * @return bool The state if the Clan satisfies the Specification.
     * @since 1.0.0
     */
    public function isSatisfiedBy(IEntity $clan)
    {
        //check if a Clan Entity is available.
        if (!($clan instanceof Clan)) {
            return false;
        }

        //find all Clan Entities with the same tag and name (unique properties).
        $clans = $this->repository->findUnique($clan->tag, $clan->name);

        //check whether the Clan Entity is unique on database.
        if (($clan->id === 0) && (count($clans) > 0)) {
            return false;
        } else {

            //filter all Clan Entities with another id.
            $clans = array_filter($clans, function(Clan $item) use($clan) {
                return $clan->id <> $item->id;
            });

            //return the state if a Clan Entity is available after filter.
            return (count($clans) === 0);
        }
    }
}
