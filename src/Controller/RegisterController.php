<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;
use Clanify\Core\Log\LogLevel;
use Clanify\Core\View;
use Clanify\Domain\Entity\User;
use Clanify\Application\Service\AuthenticationService;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Specification\User\IsUnique;
use Clanify\Domain\Specification\User\IsValidEmail;
use Clanify\Domain\Specification\User\IsValidPassword;
use Clanify\Domain\Specification\User\IsValidUsername;

/**
 * Class RegisterController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
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
        //get and load the View.
        $view = new View('Register');
        $view->load();
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

        //check if the username is valid.
        if ((new IsValidUsername())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The username is not valid!', 'register_username', LogLevel::ERROR);
            return false;
        }

        //check if the email is valid.
        if ((new IsValidEmail())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The email is not valid!', 'register_email', LogLevel::ERROR);
            return false;
        }

        //check if the password is valid.
        if ((new IsValidPassword())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The password is not valid!', 'register_password', LogLevel::ERROR);
            return false;
        }

        //check if the user is unique.
        if ((new IsUnique(UserRepository::build()))->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The User already exists!', '', LogLevel::ERROR);
            return false;
        }

        //register the User with the AuthenticationService.
        if ((new AuthenticationService())->register($user)) {
            $this->jsonOutput('The User was successfully registered!', '', LogLevel::INFO, URL.'login');
            return true;
        } else {
            $this->jsonOutput('The User could not be registered!', '', LogLevel::ERROR);
            return false;
        }
    }
}
