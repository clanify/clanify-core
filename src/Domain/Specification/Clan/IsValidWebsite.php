<?php
/**
 * Namespace for all Specifications of Clan.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Specification\Specification;

/**
 * Class IsValidWebsite
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Clan
 * @version 0.0.1-dev
 */
class IsValidWebsite extends Specification
{
    /**
     * Method to check if the Clan satisfies the Specification.
     * @param IEntity $clan The Clan which will be checked.
     * @return bool The state if the Clan satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $clan)
    {
        //check if a Clan is available.
        if ($clan instanceof Clan) {

            //check if the website is valid.
            if ((trim($clan->website) === '') || (filter_var($clan->website, FILTER_VALIDATE_URL) !== false)) {
                return true;
            }
        }

        //return the state.
        return false;
    }
}
