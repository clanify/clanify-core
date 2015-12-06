<?php
/**
 * Namespace for all Specifications of Clan.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Clan;

use Clanify\Domain\Entity\Clan;

/**
 * Interface IClanSpecification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Clan
 * @version 0.0.1-dev
 */
interface IClanSpecification
{
    /**
     * Method to check if the Clan satisfies the Specification.
     * @param Clan $clan The Clan which will be checked.
     * @return boolean The state if the Clan satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(Clan $clan);
}
