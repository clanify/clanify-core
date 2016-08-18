<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\Entity;

/**
 * Interface IEntity
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 1.0.0
 */
interface IEntity
{
    /**
     * Method to load an array to the Entity.
     * @param array $array The array which will be loaded to the Entity.
     * @param string $prefix The prefix of the keys of the array.
     * @since 1.0.0
     */
    public function loadFromArray($array, $prefix = '');

    /**
     * Method to load the GET array to the Entity.
     * @param string $prefix The prefix of the properties of the GET array.
     * @since 1.0.0
     */
    public function loadFromGET($prefix = '');

    /**
     * Method to load an object to the Entity.
     * @param object $object The object which will be loaded to the Entity.
     * @param string $prefix The prefix of the properties of the object.
     * @since 1.0.0
     */
    public function loadFromObject($object, $prefix = '');

    /**
     * Method to load the POST array to the Entity.
     * @param string $prefix The prefix of the properties of the POST array.
     * @since 1.0.0
     */
    public function loadFromPOST($prefix = '');
}
