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
 * Class IsValidWebsite
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 1.0.0
 */
class IsValidWebsite implements ISpecification
{
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

        //check if the website is empty.
        if (trim($team->website) === '') {
            return true;
        }

        //check if the protocol of the URL is valid.
        if (preg_match('/^(http:\/\/|https:\/\/)/', $team->website) == 0) {
            return false;
        }

        //check if the filter matches the website.
        return (filter_var($team->website, FILTER_VALIDATE_URL) !== false);
    }
}
