<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\Entity;

/**
 * Class Team
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 1.0.0
 */
class Team extends Entity
{
    /**
     * The name of the Team.
     * @since 1.0.0
     * @var string
     */
    public $name = '';

    /**
     * The short tag of the Team.
     * @since 1.0.0
     * @var string
     */
    public $tag = '';

    /**
     * The website of the Team.
     * @since 1.0.0
     * @var string
     */
    public $website = '';
}
