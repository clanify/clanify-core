<?php
/**
 * Namespace for all entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class User
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
class User extends Entity
{
    /**
     * The birthday of the User.
     * @since 0.0.1-dev
     * @var string
     */
    public $birthday = '0000-00-00';

    /**
     * The email address of the User.
     * @since 0.0.1-dev
     * @var string
     */
    public $email = '';

    /**
     * The firstname of the User.
     * @since 0.0.1-dev
     * @var string
     */
    public $firstname = '';

    /**
     * The gender of the User.
     * @since 0.0.1-dev
     * @var string
     */
    public $gender = '';

    /**
     * The lastname of the User.
     * @since 0.0.1-dev
     * @var string
     */
    public $lastname = '';

    /**
     * The password of the User.
     * @since 0.0.1-dev
     * @var string
     */
    public $password = '';

    /**
     * The username of the User.
     * @since 0.0.1-dev
     * @var string
     */
    public $username = '';

    /**
     * Method to get the full name of the User.
     * @return string The full name of the User.
     * @since 0.0.1-dev
     */
    public function getFullname()
    {
        return $this->firstname.' '.$this->lastname;
    }
}
