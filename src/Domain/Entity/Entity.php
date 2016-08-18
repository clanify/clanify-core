<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\Entity;

/**
 * Class Entity
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 1.0.0
 */
abstract class Entity implements IEntity
{
    /**
     * The id of the Entity.
     * @since 1.0.0
     * @var int
     */
    public $id = 0;

    /**
     * Method to load an array to the Entity.
     * @param array $array The array which will be loaded to the Entity.
     * @param string $prefix The prefix of the keys of the array.
     * @since 1.0.0
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
     * Method to load the GET array to the Entity.
     * @param string $prefix The prefix of the properties of the GET array.
     * @since 1.0.0
     */
    public function loadFromGET($prefix = '')
    {
        $this->loadFromGlobalArray(INPUT_GET, $prefix);
    }

    /**
     * Method to load an object to the Entity.
     * @param object $object The object which will be loaded to the Entity.
     * @param string $prefix The prefix of the properties of the object.
     * @since 1.0.0
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

    /**
     * Method to load the POST array to the Entity.
     * @param string $prefix The prefix of the properties of the POST array.
     * @since 1.0.0
     */
    public function loadFromPOST($prefix = '')
    {
        $this->loadFromGlobalArray(INPUT_POST, $prefix);
    }

    /**
     * Method to load a value from a global array.
     * @param int $global The constant of the global array which will be loaded to the Entity.
     * @param string $prefix The prefix of the properties of the global array.
     * @since 1.0.0
     */
    private function loadFromGlobalArray($global, $prefix = '')
    {
        //map all the doc comment types to the globals.
        $filterMap['string'] = FILTER_DEFAULT;
        $filterMap['int'] = FILTER_VALIDATE_INT;
        $filterMap['bool'] = FILTER_VALIDATE_BOOLEAN;

        //run through all class properties.
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $globalProperty = $prefix.$property;

            //check if the property name exists on the global.
            if (filter_input($global, $globalProperty) !== null) {
                $reflection = new \ReflectionProperty(get_class($this), $property);

                //Get type from doc comments.
                if (preg_match('/@var\s+([^\s]+)/', $reflection->getDocComment(), $matches)) {
                    $value = filter_input($global, $globalProperty, $filterMap[$matches[1]], FILTER_NULL_ON_FAILURE);

                    //check if the validation was successfully.
                    if ($value !== null) {
                        $this->$property = $value;
                    }
                }
            }
        }
    }
}
