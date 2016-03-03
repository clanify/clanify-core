<?php
/**
 * Namespace for all core functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

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
     */
    protected function needSession($redirectURL = URL)
    {
        //create the session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //check if the session is available.
        if (isset($_SESSION['user_username']) === false) {
            $this->redirect($redirectURL);
        }
    }

    /**
     * Method to create a JSON output for AJAX calls.
     * @param string $message The message which will be showed.
     * @param string $field The name of the field which is affected.
     * @param string $level The message level of the output.
     * @param string $redirect The URL to redirect on success.
     * @since 0.0.1-dev
     */
    protected function jsonOutput($message, $field, $level, $redirect = URL)
    {
        $output = array();
        $output['message'] = $message;
        $output['field'] = $field;
        $output['state'] = $level;
        $output['redirect'] = $redirect;
        echo json_encode($output);
    }
}
