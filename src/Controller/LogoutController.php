<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Application\Service\AuthenticationService;
use Clanify\Core\Controller;

/**
 * Class LogoutController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class LogoutController extends Controller
{
    /**
     * The index (default) action of the Logout.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //load the needed session.
        $this->needSession();

        //logout the user and redirect.
        if ((new AuthenticationService())->logout()) {
            $this->redirect(URL);
        }
    }
}
