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
     * Method to get the age of the User.
     * @return int
     * @since 0.0.1-dev
     */
    public function getAge()
    {
        //convert the date string to a date object.
        $date = \DateTime::createFromFormat('Y-m-d', $this->birthday);

        //check if the date is valid.
        if ($date && $date->format('Y-m-d') == $this->birthday) {
            $birthDate = explode('-', $this->birthday);

            //check if the actual year can be used.
            if (date('md', date('U', mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date('md')) {
                return ((date('Y') - $birthDate[0]) - 1);
            } else {
                return (date('Y') - $birthDate[0]);
            }
        } else {
            return -1;
        }
    }

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
