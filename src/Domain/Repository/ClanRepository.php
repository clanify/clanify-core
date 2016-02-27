<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Repository;

use Clanify\Core\Database;
use Clanify\Domain\DataMapper\ClanMapper;

/**
 * Class ClanRepository
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 0.0.1-dev
 */
class ClanRepository extends Repository
{
    /**
     * Method to build a new object of ClanRepository.
     * @return ClanRepository The created object of ClanRepository.
     * @since 0.0.1-dev
     */
    public static function build()
    {
        $mapper = new ClanMapper(Database::getInstance()->getConnection());
        return new self($mapper);
    }

    /**
     * Method to find all Clan Entities.
     * @return array An array with all found Clan Entities.
     * @since 0.0.1-dev
     */
    public function findAll()
    {
        //check if a ClanMapper is available.
        if (!($this->dataMapper instanceof ClanMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Clan Entities by ID.
     * @param int $id The ID to find the Clan Entities.
     * @return array An array with all found Clan Entities.
     * @since 0.0.1-dev
     */
    public function findByID($id)
    {
        //check if a ClanMapper is available.
        if (!($this->dataMapper instanceof ClanMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Clan Entities by name.
     * @param string $name The name to find the Clan Entities.
     * @return array An array with all found Clan Entities.
     * @since 0.0.1-dev
     */
    public function findByName($name)
    {
        //check if a ClanMapper is available.
        if (!($this->dataMapper instanceof ClanMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($name)) {
            $condition = "name IN ('".implode("', '", $name)."')";
        } else {
            $condition = "name = '".$name."'";
        }

        //return the result of the ClanMapper.
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find Clan Entities by tag.
     * @param string $tag The tag to find the Clan Entities.
     * @return array An array with all found Clan Entities.
     * @since 0.0.1-dev
     */
    public function findByTag($tag)
    {
        //check if a ClanMapper is available.
        if (!($this->dataMapper instanceof ClanMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($tag)) {
            $condition = "tag IN ('".implode("', '", $tag)."')";
        } else {
            $condition = "tag = '".$tag."'";
        }

        //return the result of the ClanMapper.
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find Clan Entities by website.
     * @param string $website The website to find the Clan Entities.
     * @return array An array with all found Clan Entities.
     * @since 0.0.1-dev
     */
    public function findByWebsite($website)
    {
        //check if a ClanMapper is available.
        if (!($this->dataMapper instanceof ClanMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($website)) {
            $condition = "website IN ('".implode("', '", $website)."')";
        } else {
            $condition = "website = '".$website."'";
        }

        //return the result of the ClanMapper.
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find a Clan by unique parameters.
     * @param string $tag The tag to find the Clan Entity.
     * @param string $name The name to find the Clan Entity.
     * @return array An array with all found Clan Entities.
     * @since 0.0.1-dev
     */
    public function findUnique($tag, $name)
    {
        //check if a ClanMapper is available.
        if (!($this->dataMapper instanceof ClanMapper)) {
            return [];
        }

        //create the condition and return the result.
        $condition = "tag = '".$tag."' AND name = '".$name."'";
        return $this->dataMapper->find($condition);
    }
}
