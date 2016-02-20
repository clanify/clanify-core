<?php
/**
 * Namespace for all common Specifications.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Common;

use Clanify\Domain\Entity\Entity;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Specification\Specification;

/**
 * Class IsValidID
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Common
 * @version 0.0.1-dev
 */
class IsValidID extends Specification
{
    /**
     * Method to check if the Entity satisfies the Specification.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $entity)
    {
        //check if an Entity is available.
        if ($entity instanceof Entity) {
            return (preg_match('/^[0-9]+$/', $entity->id) === 1);
        } else {
            return false;
        }
    }
}
