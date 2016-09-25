<?php
/**
 * Namespace for all Controller of Clanify.
 * @package Clanify\Controller
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;
use Clanify\Core\Database;
use Clanify\Core\Log\LogLevel;
use Clanify\Core\View;
use Clanify\Domain\DataMapper\AccountMapper;
use Clanify\Domain\DataMapper\UserMapper;
use Clanify\Domain\Entity\Account;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\AccountRepository;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Service\User\HashingService;
use Clanify\Domain\Specification\User\IsValidBirthday;
use Clanify\Domain\Specification\User\IsValidEmail;
use Clanify\Domain\Specification\User\IsValidFirstname;
use Clanify\Domain\Specification\User\IsValidGender;
use Clanify\Domain\Specification\User\IsValidLastname;
use Clanify\Domain\Specification\User\IsValidPassword;
use Clanify\Domain\Specification\User\IsValidUsername;
use Clanify\Domain\TableMapper\AccountUserTableMapper;

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

            $accountRepository = AccountRepository::build();
            $accounts = $accountRepository->findByUser($user);
            $view->setVar('accounts', $accounts);
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

    /**
      * Method to create a new Account for a User.
     * @param int $user_id The ID of the User for which the Account would be created.
     * @param int $account_id The ID of the Account which will be created.
     * @return boolean The state whether the Account could be created.
     * @since 1.0.0
     */
    public function createAccount($user_id = 0, $account_id = 0)
    {
        //use the edit method to create a new Account.
        return $this->editAccount($user_id, $account_id);
    }

    /**
     * Method to delete a Account from a User.
     * @param int $user_id The ID of the User which Account would be removed.
     * @param int $account_id The ID of the Account which will be removed.
     * @return bool The state whether the Account could be removed.
     * @since 1.0.0
     */
    public function deleteAccount($user_id = 0, $account_id = 0)
    {
        //this method need a Session.
        $this->needSession();

        //check whether both IDs are 0.
        if ($user_id === 0 && $account_id === 0) {

            //get the ID of the Account.
            $account_id = filter_input(INPUT_POST, 'account_id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

            //get the ID of the User.
            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        }

        //create the UserRepository to load the User from database.
        $userRepository = UserRepository::build();
        $users = $userRepository->findByID($user_id);

        //check whether the User could be loaded from database.
        if (count($users) !== 1) {
            $jsonOutput = [];
            $jsonOutput['state'] = LogLevel::ERROR;
            $jsonOutput['message'] = 'The User could not be found.';
            $jsonOutput['redirect'] = '';
            $jsonOutput['tab_selected'] = '';
            echo json_encode($jsonOutput);
            return false;
        }

        //create the AccountRepository to load the Account from database.
        $accountRepository = AccountRepository::build();
        $accounts = $accountRepository->findByID($account_id);

        //check whether the Account could be loaded from database.
        if (count($accounts) !== 1) {
            $jsonOutput = [];
            $jsonOutput['state'] = LogLevel::ERROR;
            $jsonOutput['message'] = 'The Account could not be found.';
            $jsonOutput['redirect'] = '';
            $jsonOutput['tab_selected'] = '';
            echo json_encode($jsonOutput);
            return false;
        }

        //create the TableMapper to remove the association.
        $accountUserTableMapper = AccountUserTableMapper::build();

        //check whether the association between User and Account could be removed.
        if ($accountUserTableMapper->delete($accounts[0], $users[0])) {

            //create the AccountMapper to remove the Account.
            $accountMapper = AccountMapper::build();

            //check whether the Account could be removed.
            if ($accountMapper->delete($accounts[0])) {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::INFO;
                $jsonOutput['message'] = 'The Account was successfully removed.';
                $jsonOutput['redirect'] = URL . "user/edit/" . $user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return true;
            } else {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::ERROR;
                $jsonOutput['message'] = 'The Account could not be removed.';
                $jsonOutput['redirect'] = '';
                $jsonOutput['tab_selected'] = '';
                echo json_encode($jsonOutput);
                return false;
            }
        } else {
            $jsonOutput = [];
            $jsonOutput['state'] = LogLevel::ERROR;
            $jsonOutput['message'] = 'The Account could not be removed.';
            $jsonOutput['redirect'] = '';
            $jsonOutput['tab_selected'] = '';
            echo json_encode($jsonOutput);
            return false;
        }
    }

    /**
     * Method to add or edit a Account.
     * @param int $user_id The ID of the User of which the Account would be added or edited.
     * @param int $account_id The ID of the Account which will be added (ID = 0) or edited (ID > 0).
     * @return boolean The state whether the Account could be loaded for add or edit.
     * @since 1.0.0
     */
    public function editAccount($user_id = 0, $account_id = 0)
    {
        //this method need a Session.
        $this->needSession();

        //create a new View to create or edit a Account.
        $view = new View('User', 'EditAccount');
        $view->setVar('backend', true);

        //create the UserRepository to load the User from database.
        $userRepository = UserRepository::build();
        $users = $userRepository->findByID($user_id);

        //check whether the User could be loaded from database.
        if (count($users) === 1) {
            $view->setVar('user', $users[0]);
        } else {
            $jsonOutput = [];
            $jsonOutput['state'] = LogLevel::ERROR;
            $jsonOutput['message'] = 'The User could not be found.';
            $jsonOutput['redirect'] = '';
            $jsonOutput['tab_selected'] = '';
            echo json_encode($jsonOutput);
            return false;
        }

        //check whether a Account ID is available.
        if ($account_id > 0) {

            //create the AccountRepository to load the Account from database.
            $accountRepository = AccountRepository::build();
            $accounts = $accountRepository->findByID($account_id);

            //check whether the Account could be loaded from database.
            if (count($accounts) === 1) {
                $view->setVar('account', $accounts[0]);
            } else {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::ERROR;
                $jsonOutput['message'] = 'The Account could not be found.';
                $jsonOutput['redirect'] = '';
                $jsonOutput['tab_selected'] = '';
                echo json_encode($jsonOutput);
                return false;
            }
        }

        //load the View.
        $view->load();
        return true;
    }

    /**
     * Method to save the Account.
     * @return boolean The state whether the Account could be saved.
     * @since 1.0.0
     */
    public function accountSave()
    {
        //this method need a Session.
        $this->needSession();

        //get the ID of the Account.
        $account_id = filter_input(INPUT_POST, 'account_id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        //get the ID of the User.
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        //check whether a Account should be updated.
        if ($account_id > 0) {

            //create the AccountRepository to load the Account from database.
            $accountRepository = AccountRepository::build();
            $accounts = $accountRepository->findByID($account_id);

            //check whether the Account could be loaded with the AccountRepository.
            if (count($accounts) !== 1) {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::ERROR;
                $jsonOutput['message'] = 'The Account could not be found.';
                $jsonOutput['redirect'] = URL.'user/edit/'.$user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return false;
            }

            //create a new Account and load the Account from database.
            $account = new Account();
            $account->loadFromObject($accounts[0]);
            $account->loadFromPOST('account_');

            //create a AccountMapper to save the Account on database.
            $accountMapper = AccountMapper::build();

            //check whether the Account could be saved.
            if ($accountMapper->save($account)) {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::INFO;
                $jsonOutput['message'] = 'The Account was successfully saved.';
                $jsonOutput['redirect'] = URL.'user/edit/'.$user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return true;
            } else {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::ERROR;
                $jsonOutput['message'] = 'The Account could not be saved.';
                $jsonOutput['redirect'] = URL.'user/edit/'.$user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return false;
            }
        } else {

            //create the UserRepository to load the User from database.
            $userRepository = UserRepository::build();
            $users = $userRepository->findByID($user_id);

            //check whether the User could be loaded with the UserRepository.
            if (count($users) !== 1) {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::ERROR;
                $jsonOutput['message'] = 'The User of the Account could not be found.';
                $jsonOutput['redirect'] = URL.'user/edit/'.$user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return false;
            }

            //create a new Account and load the Account.
            $account = new Account();
            $account->loadFromPOST('account_');

            //create a AccountDataMapper to save the Account on database.
            $accountMapper = AccountMapper::build();

            //check whether the new Account could be saved.
            if ($accountMapper->save($account) === false) {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::ERROR;
                $jsonOutput['message'] = 'The Account could not be saved!';
                $jsonOutput['redirect'] = URL.'user/edit/'.$user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return false;
            }

            //get the ID of the new Account on database.
            $account->id = Database::getInstance()->getConnection()->lastInsertId();

            //create a new Account User TableMapper.
            $accountUserTableMapper = AccountUserTableMapper::build();

            //check whether the association between Account and User could be created.
            if ($accountUserTableMapper->create($account, $users[0])) {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::INFO;
                $jsonOutput['message'] = 'The Account was successfully created.';
                $jsonOutput['redirect'] = URL.'user/edit/'.$user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return true;
            } else {
                $jsonOutput = [];
                $jsonOutput['state'] = LogLevel::ERROR;
                $jsonOutput['message'] = 'The Account could not be saved!';
                $jsonOutput['redirect'] = URL.'user/edit/'.$user_id;
                $jsonOutput['tab_selected'] = 'tab-accounts';
                echo json_encode($jsonOutput);
                return false;
            }
        }
    }
}
