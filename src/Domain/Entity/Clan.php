<?php
/**
 * Namespace for all entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class Clan
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
class Clan extends Entity
{
    /**
     * The name of the Clan.
     * @since 0.0.1-dev
     * @var string
     */
    public $name = '';

    /**
     * The short tag of the Clan.
     * @since 0.0.1-dev
     * @var string
     */
    public $tag = '';

    /**
     * The website of the Clan.
     * @since 0.0.1-dev
     * @var string
     */
    public $website = '';
}
