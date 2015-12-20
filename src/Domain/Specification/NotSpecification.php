<?php
/**
 * Namespace for all Specifications.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification;

use Clanify\Domain\Entity\IEntity;

/**
 * Class NotSpecification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification
 * @version 0.0.1-dev
 */
class NotSpecification implements ISpecification
{
    /**
     * The Specification which will be used.
     * @since 0.0.1-dev
     * @var ISpecification|null
     */
    private $specification = null;

    /**
     * NotSpecification constructor.
     * @param ISpecification $specification The Specification which will be used.
     * @since 0.0.1-dev
     */
    public function __construct(ISpecification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * Method to check if the Entity not satisfies the Specifications (NOT).
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity not satisfies the Specifications (NOT).
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $entity)
    {
        return !$this->specification->isSatisfiedBy($entity);
    }
}
