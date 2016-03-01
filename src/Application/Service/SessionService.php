<?php
/**
 * Namespace for all Application Services of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Application\Service;

use Clanify\Core\Database;
use Clanify\Core\Session;
use Clanify\Domain\Entity\User;

/**
 * Class SessionService
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Application\Service
 * @version 0.0.1-dev
 */
class SessionService
{
    /**
     * Method to create a session for a specific User Entity.
     * @param User $user The User Entity with the information for the session.
     * @return bool The state if the session was created successfully.
     * @since 0.0.1-dev
     */
    public function create(User $user)
    {
        //create the session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //set the information to the session.
        $_SESSION['user_username'] = $user->username;
        return true;
    }

    /**
     * Method to delete a session.
     * @return bool The state if the session could be removed successfully.
     * @since 0.0.1-dev
     */
    public function delete()
    {
        session_destroy();
        return true;
    }
}
