<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class Role
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
class Role extends Entity
{
    /**
     * The name of the Role.
     * @since 0.0.1-dev
     * @var string
     */
    public $name = '';
}
