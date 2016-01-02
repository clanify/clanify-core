<?php
/**
 * Namespace for all Entities of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Entity;

/**
 * Class Session
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Entity
 * @version 0.0.1-dev
 */
class Session extends Entity
{
    /**
     * Method to create a session.
     * @since 0.0.1-dev
     */
    public static function create()
    {
        //set the session settings.
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.cookie_httponly', 1);

        //set the session name.
        session_name('clanify');

        //start the session.
        session_start();

        //regenerate the session and delete the old one.
        session_regenerate_id(true);
    }

    /**
     * Method to destroy a session.
     * @since 0.0.1-dev
     */
    public static function destroy()
    {
        //expire the session.
        setcookie(session_name(), '', time() - 3600);

        //destroy the session.
        session_destroy();
    }
}
