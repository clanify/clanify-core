<?php
/**
 * Namespace for all Specifications of Permission.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Permission;

use Clanify\Domain\Entity\Permission;

/**
 * Interface IPermissionSpecification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Permission
 * @version 0.0.1-dev
 */
interface IPermissionSpecification
{
    /**
     * Method to check if the Permission satisfies the Specification.
     * @param Permission $permission The Permission which will be checked.
     * @return boolean The state if the Permission satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(Permission $permission);
}
