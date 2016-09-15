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
 * Class IsValidWebsite
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Clan
 * @version 1.0.0
 */
class IsValidWebsite implements ISpecification
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
        if (!($clan instanceof Clan)) {
            return false;
        }

        //check if the website is empty.
        if (trim($clan->website) === '') {
            return true;
        }

        //check if the protocol of the URL is valid.
        if (preg_match('/^(http:\/\/|https:\/\/)/', $clan->website) == 0) {
            return false;
        }

        //check if the filter matches the website.
        return (filter_var($clan->website, FILTER_VALIDATE_URL) !== false);
    }
}
