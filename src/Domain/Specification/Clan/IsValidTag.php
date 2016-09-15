<?php
/**
 * Namespace for all Specifications of Clan.
 * @since 1.0.0
 */
namespace Clanify\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class IsValidTag
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Clan
 * @version 1.0.0
 */
class IsValidTag implements ISpecification
{
    /**
     * Method to check if the Clan satisfies the Specification.
     * @param IEntity $clan The Clan which will be checked.
     * @return bool The state if the Clan satisfies the Specification.
     * @since 1.0.0
     */
    public function isSatisfiedBy(IEntity $clan)
    {
        //check if a Clan Entity is available.
        if ($clan instanceof Clan) {
            return (preg_match('/^[A-Za-z0-9]{2,5}$/', $clan->tag) === 1);
        } else {
            return false;
        }
    }
}
