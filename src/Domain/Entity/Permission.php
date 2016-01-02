<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class Permission
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
class Permission extends Entity
{
    /**
     * The name of the Permission.
     * @since 0.0.1-dev
     * @var string
     */
    public $name = '';
}
