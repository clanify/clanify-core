<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Service\UserService;

/**
 * Class LoginController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class LoginController extends Controller
{
    /**
     * The index (default) action of the Login.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //get the view.
        $this->includeHeader();
        $this->includeView('Login', 'Index');
        $this->includeFooter();
    }

    /**
     * The login action of the Login.
     * @since 0.0.1-dev
     */
    public function login()
    {
        //get the user from the login form.
        $user = new User();
        $user->loadFromPOST('login_');

        //create a user service.
        $userService = new UserService();

        //try to login the user.
        if ($userService->login($user)) {
            header('Location: '.URL.'dashboard');
        } else {
            header('Location: '.URL.'login');
        }
    }
}
