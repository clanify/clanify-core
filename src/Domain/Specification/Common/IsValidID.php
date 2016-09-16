<?php
/**
 * Namespace for all common Specifications.
 * @since 1.0.0
 */
namespace Clanify\Domain\Specification\Common;

use Clanify\Domain\Entity\Entity;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class IsValidID
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Common
 * @version 1.0.0
 */
class IsValidID implements ISpecification
{
    /**
     * Method to check if the Entity satisfies the Specification.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specification.
     * @since 1.0.0
     */
    public function isSatisfiedBy(IEntity $entity)
    {
        return (($entity instanceof Entity) && (preg_match('/^[0-9]+$/', $entity->id)) === 1);
    }
}
