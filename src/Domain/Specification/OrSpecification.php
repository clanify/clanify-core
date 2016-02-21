<?php
/**
 * Namespace for all Specifications.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification;

use Clanify\Domain\Entity\IEntity;

/**
 * Class OrSpecification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification
 * @version 0.0.1-dev
 */
class OrSpecification implements ISpecification
{
    /**
     * The left Specification which will be used.
     * @since 0.0.1-dev
     * @var ISpecification|null
     */
    private $leftSpecification = null;

    /**
     * The right Specification which will be used.
     * @since 0.0.1-dev
     * @var ISpecification|null
     */
    private $rightSpecification = null;

    /**
     * OrSpecification constructor.
     * @param ISpecification $leftSpecification The left Specification which will be used.
     * @param ISpecification $rightSpecification The right Specification which will be used.
     * @since 0.0.1-dev
     */
    public function __construct(ISpecification $leftSpecification, ISpecification $rightSpecification)
    {
        $this->leftSpecification = $leftSpecification;
        $this->rightSpecification = $rightSpecification;
    }

    /**
     * Method to check if the Entity satisfies the Specifications (OR).
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specifications (OR).
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $entity)
    {
        return $this->leftSpecification->isSatisfiedBy($entity) || $this->rightSpecification->isSatisfiedBy($entity);
    }
}
