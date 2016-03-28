<?php
/**
 * Namespace for all Controller of Clanify.
 * @package Clanify\Controller
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;
use Clanify\Core\Log\LogLevel;
use Clanify\Core\View;
use Clanify\Domain\DataMapper\UserMapper;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Service\User\HashingService;
use Clanify\Domain\Specification\User\IsValidBirthday;
use Clanify\Domain\Specification\User\IsValidEmail;
use Clanify\Domain\Specification\User\IsValidFirstname;
use Clanify\Domain\Specification\User\IsValidGender;
use Clanify\Domain\Specification\User\IsValidLastname;
use Clanify\Domain\Specification\User\IsValidPassword;
use Clanify\Domain\Specification\User\IsValidUsername;

/**
 * Class UserController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class UserController extends Controller
{
    /**
     * The index (default) action of the User.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //get the session.
        $this->needSession();

        //get the view.
        $view = new View('User');
        $view->setVar('users', UserRepository::build()->findAll());
        $view->setVar('backend', true);
        $view->load();
    }

    /**
     * The create action of the User.
     * @since 0.0.1-dev
     */
    public function create()
    {
        $this->edit();
    }

    /**
     * The delete action of the User.
     * @param int $id The ID of the User which will be deleted.
     * @since 0.0.1-dev
     */
    public function delete($id)
    {
        //get the session.
        $this->needSession();

        //check if a valid ID is available.
        if (is_numeric($id) && ($id > 0)) {
            $users = UserRepository::build()->findByID($id);

            //check if the User is available.
            if (count($users) === 1) {
                if (UserMapper::build()->delete($users[0])) {
                    $this->redirect(URL.'user');
                } else {
                    $this->redirect(URL.'user/edit/'.$id);
                }
            }
        }

        //redirect to the overview of the Users.
        $this->redirect(URL.'user');
    }

    /**
     * The edit action of the User.
     * @param int $id The ID of the User which will be edit (0 = new user).
     * @since 0.0.1-dev
     */
    public function edit($id = 0)
    {
        //get the session.
        $this->needSession();

        //initialize a new user entity.
        $user = new User();
        $view = new View('User', 'Edit');

        //check if a User should be loaded.
        if (is_numeric($id) && ($id > 0)) {

            //find all the users.
            $users = UserRepository::build()->findByID((int) $id);

            //check if a user is available.
            if (count($users)) {
                $user = $users[0];
            } else {
                $this->redirect(URL.'user/create');
            }
        }

        $view->setVar('user', $user);
        $view->setVar('backend', true);
        $view->load();
    }

    /**
     * The save action of the User.
     * @return bool The state if the User was successfully saved.
     * @since 0.0.1-dev
     */
    public function save()
    {
        //get the session.
        $this->needSession();

        //get the information from post.
        $user = new User();
        $user->loadFromPOST('user_');

        //check if the birthday is valid.
        if ((new IsValidBirthday())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The birthday is not valid!', 'user_birthday', LogLevel::ERROR);
            return false;
        }

        //check if the email is valid.
        if ((new IsValidEmail())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The email is not valid!', 'user_email', LogLevel::ERROR);
            return false;
        }

        //check if the firstname is valid.
        if ((new IsValidFirstname())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The firstname is not valid!', 'user_firstname', LogLevel::ERROR);
            return false;
        }

        //check if the gender is valid.
        if ((new IsValidGender())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The gender is not valid!', 'user_gender', LogLevel::ERROR);
            return false;
        }

        //check if the lastname is valid.
        if ((new IsValidLastname())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The lastname is not valid!', 'user_lastname', LogLevel::ERROR);
            return false;
        }

        //check if the username is valid.
        if ((new IsValidUsername())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The username is not valid!', 'user_username', LogLevel::ERROR);
            return false;
        }

        //check if a password is given.
        if (($user->password !== '') || ($user->id < 1)) {

            //check if the password is valid.
            if ((new IsValidPassword())->isSatisfiedBy($user) === false) {
                $this->jsonOutput('The password is not valid!', 'user_password', LogLevel::ERROR);
                return false;
            } else {
                $hashingService = new HashingService();
                $user = $hashingService->hash($user);
            }
        }

        //check if the password should be changed.
        if ($user->password === '') {
            $userDB = UserRepository::build()->findByID($user->id);

            //check if the User Entity was found.
            if (count($userDB) === 1) {
                $userDB = $userDB[0];

                //check if the ID is the same.
                if ($user->id == $userDB->id) {
                    $user->password = $userDB->password;
                    $user->salt = $userDB->salt;
                } else {
                    $this->jsonOutput('The User could not be saved!', '', LogLevel::ERROR);
                    return false;
                }
            }
        }

        //save the User on the database.
        if (UserMapper::build()->save($user)) {
            $this->jsonOutput('The User was saved successfully!', '', LogLevel::INFO, URL.'user');
            return true;
        } else {
            $this->jsonOutput('The User could not be saved!', '', LogLevel::ERROR);
            return false;
        }
    }
}
