<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class Account
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
class Account extends Entity
{
    /**
     * The name of the Account.
     * @since 0.0.1-dev
     * @var string
     */
    public $name = '';

    /**
     * The value of the Account.
     * @since 0.0.1-dev
     * @var string
     */
    public $value = '';
}
