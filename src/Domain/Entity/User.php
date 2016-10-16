<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\Entity;

/**
 * Class User
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 1.0.0
 */
class User extends Entity
{
    /**
     * The birthday of the User.
     * @since 1.0.0
     * @var string
     */
    public $birthday = '0000-00-00';

    /**
     * The email address of the User.
     * @since 1.0.0
     * @var string
     */
    public $email = '';

    /**
     * The firstname of the User.
     * @since 1.0.0
     * @var string
     */
    public $firstname = '';

    /**
     * The gender of the User.
     * @since 1.0.0
     * @var string
     */
    public $gender = '';

    /**
     * The lastname of the User.
     * @since 1.0.0
     * @var string
     */
    public $lastname = '';

    /**
     * The password of the User.
     * @since 1.0.0
     * @var string
     */
    public $password = '';

    /**
     * The salt of the password (for hashing).
     * @since 1.0.0
     * @var string
     */
    public $salt = '';

    /**
     * The username of the User.
     * @since 1.0.0
     * @var string
     */
    public $username = '';

    /**
     * Method to get the age of the User.
     * @return int The age of the User (>= 0) or -1 on failure.
     * @since 1.0.0
     */
    public function getAge()
    {
        //check whether the default is available.
        if ($this->birthday === '0000-00-00') {
            return -1;
        }

        //create both dates (birthday and today).
        $birthday = date_create($this->birthday);
        $today = date_create(date('Y-m-d'));

        //check if the dates are valid.
        if (($birthday !== false && $today !== false) && ($birthday < $today)) {
            return date_diff($birthday, $today)->y;
        } else {
            return -1;
        }
    }

    /**
     * Method to get the full name of the User.
     * @return string The full name of the User.
     * @since 1.0.0
     */
    public function getFullname()
    {
        return $this->firstname.' '.$this->lastname;
    }
}
