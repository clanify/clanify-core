<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Domain\Entity\Session;

/**
 * Class LogoutController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class LogoutController
{
    /**
     * The index (default) action of the Logout.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //destroy the session.
        Session::create();
        Session::destroy();
        header('Location: '.URL);
    }
}
