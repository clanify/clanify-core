<?php
/**
 * Namespace for all core functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

use Clanify\Domain\Entity\Session;

/**
 * Class Controller
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core
 * @version 0.0.1-dev
 */
class Controller
{
    /**
     * Method to redirect to an URL.
     * @param string $url The target URL.
     * @since 0.0.1-dev
     */
    protected function redirect($url)
    {
        //redirect only if the URL is valid.
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            header('Location: '.$url);
        }
    }

    /**
     * Method to load and check if a session is available.
     * @param string $redirectURL The url which will be used for redirect.
     * @since 0.0.1-dev
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function needSession($redirectURL = URL)
    {
        //initialize the session.
        Session::create();

        //check if the session is available.
        if (isset($_SESSION['user_username']) === false) {
            $this->redirect($redirectURL);
        }
    }
}
