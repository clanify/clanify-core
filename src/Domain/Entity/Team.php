<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class Team
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
class Team extends Entity
{
    /**
     * The name of the Team.
     * @since 0.0.1-dev
     * @var string
     */
    public $name = '';

    /**
     * The short tag of the Team.
     * @since 0.0.1-dev
     * @var string
     */
    public $tag = '';

    /**
     * The website of the Team.
     * @since 0.0.1-dev
     * @var string
     */
    public $website = '';
}
