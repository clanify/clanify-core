<?php
/**
 * Namespace for all Specifications.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification;

use Clanify\Domain\Entity\IEntity;

/**
 * Interface ISpecfifcation
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification
 * @version 0.0.1-dev
 */
interface ISpecification
{
    /**
     * Method to check if the Entity satisfies the Specification.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $entity);
}
