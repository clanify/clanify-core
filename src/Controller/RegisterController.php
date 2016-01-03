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
 * Class RegisterController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class RegisterController extends Controller
{
    /**
     * The index (default) action of the Register.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //get the view.
        $this->includeHeader();
        $this->includeView('Register', 'Index');
        $this->includeFooter();
    }

    /**
     * The register action of the Register.
     * @since 0.0.1-dev
     */
    public function register()
    {
        //load the user from register form.
        $user = new User();
        $user->loadFromPOST('register_');

        //create a user service.
        $userService = new UserService();

        //try to register the user.
        if ($userService->register($user)) {
            header('Location: '.URL.'login');
        } else {
            header('Location: '.URL.'register');
        }
    }
}
