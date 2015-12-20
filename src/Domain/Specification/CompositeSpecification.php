<?php
/**
 * Namespace for all Specifications.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification;

use Clanify\Domain\Entity\IEntity;

/**
 * Class CompositeSpecification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification
 * @version 0.0.1-dev
 */
class CompositeSpecification implements ISpecification
{
    /**
     * The Specifications which will be used.
     * @since 0.0.1-dev
     * @var ISpecification[]
     */
    private $specifications = [];

    /**
     * CompositeSpecification constructor.
     * @param ISpecification $specification,...
     * @since 0.0.1-dev
     */
    public function __construct(ISpecification $specification)
    {
        foreach (func_get_args() as $specification) {
            if ($specification instanceof ISpecification) {
                $this->specifications[] = $specification;
            }
        }
    }

    /**
     * Method to check if the Entity satisfies the Specifications.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specifications.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $entity)
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($entity)) {
                return false;
            }
        }
        return true;
    }
}
