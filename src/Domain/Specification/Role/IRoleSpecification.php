<?php
/**
 * Namespace for all Specifications of Role.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Role;

use Clanify\Domain\Entity\Role;

/**
 * Interface IRoleSpecification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Role
 * @version 0.0.1-dev
 */
interface IRoleSpecification
{
    /**
     * Method to check if the Role satisfies the Specification.
     * @param Role $role The Role which will be checked.
     * @return boolean The state if the Role satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(Role $role);
}
