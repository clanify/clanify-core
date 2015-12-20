<?php
/**
 * Namespace for all entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class Entity
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
abstract class Entity implements IEntity
{
    /**
     * The id of the Entity.
     * @since 0.0.1-dev
     * @var int
     */
    public $id = 0;

    /**
     * Method to load an array to the Entity.
     * @param array $array The array which will be loaded to the Entity.
     * @param string $prefix Optional. The prefix of the keys of the array.
     * @since 0.0.1-dev
     */
    public function loadFromArray($array, $prefix = '')
    {
        //run through all class properties.
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $arrayProperty = $prefix.$property;

            //check if the property name exists on the assoc array.
            if (isset($array[$arrayProperty]) === true) {
                $this->$property = $array[$arrayProperty];
            }
        }
    }

    /**
     * Method to load an object to the Entity.
     * @param object $object The object which will be loaded to the Entity.
     * @param string $prefix Optional. The prefix of the properties of the object.
     * @since 0.0.1-dev
     */
    public function loadFromObject($object, $prefix = '')
    {
        //run through all class properties.
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $objectProperty = $prefix.$property;

            //check if the property name exists on the object.
            if (isset($object->$objectProperty) === true) {
                $this->$property = $object->$objectProperty;
            }
        }
    }
}
