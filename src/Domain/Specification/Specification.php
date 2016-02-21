<?php
/**
 * Namespace for all Specifications.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification;

/**
 * Class Specification
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification
 * @version 0.0.1-dev
 */
abstract class Specification implements ISpecification
{
    /**
     * The state if the ID should be excluded.
     * @since 0.0.1-dev
     * @var bool
     */
    protected $excludeID = false;

    /**
     * Specification constructor.
     * @param bool $excludeID The state if the ID should be checked.
     * @since 0.0.1-dev
     */
    public function __construct($excludeID = false)
    {
        $this->excludeID = $excludeID;
    }

    /**
     * Method to exclude an Entity from the Entity array.
     * @param array $entities The array with all Entities.
     * @param object $object The Entity which will be excluded from the array.
     * @return bool The state if an other Entity is available.
     * @since 0.0.1-dev
     */
    protected function excludeCurrentID($entities, $object)
    {
        //run through all Entities.
        foreach ($entities as $entity) {
            if ((get_class($entity) === get_class($object)) && ($entity->id <> $object->id)) {
                return false;
            }
        }

        //return the state.
        return true;
    }
}
