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
use Clanify\Domain\DataMapper\ClanMapper;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Repository\ClanRepository;
use Clanify\Domain\Repository\TeamRepository;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Service\Clan\ClanService;
use Clanify\Domain\Specification\Clan\IsUnique;
use Clanify\Domain\Specification\Clan\IsValidName;
use Clanify\Domain\Specification\Clan\IsValidTag;
use Clanify\Domain\Specification\Clan\IsValidWebsite;

/**
 * Class ClanController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class ClanController extends Controller
{
    /**
     * The index (default) action of the Clan.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //load the needed session.
        $this->needSession();

        //get and load the view.
        $view = new View('Clan', 'Index');
        $view->setVar('clans', ClanRepository::build()->findAll());
        $view->setVar('backend', true);
        $view->load();
    }

    /**
     * The create action of the Clan.
     * @since 0.0.1-dev
     */
    public function create()
    {
        $this->edit();
    }

    /**
     * The delete action of the Clan.
     * @param int $id The id of the Clan which should be deleted.
     * @since 0.0.1-dev
     */
    public function delete($id)
    {
        //load the needed session.
        $this->needSession();

        //check if the ID is available.
        if (is_numeric($id) && ($id > 0)) {

            //find the Clans with specified ID from database.
            $clans = ClanRepository::build()->findByID($id);

            //check if a Clan is available.
            if (count($clans)) {
                $clan = $clans[0];

                //delete the Clan on database.
                if (ClanMapper::build()->delete($clan)) {
                    $this->redirect(URL.'clan');
                }
            }
        }

        //redirect to the index view.
        $this->redirect(URL.'clan');
    }

    /**
     * The edit action of the Clan.
     * @param int $id The ID of the Clan which should be edited.
     * @since 0.0.1-dev
     */
    public function edit($id = 0)
    {
        //load the needed session.
        $this->needSession();

        //initialize a new Clan.
        $clan = new Clan();
        $view = new View('Clan', 'Edit');

        //check if the ID is available.
        if (is_numeric($id) && ($id > 0)) {

            //find the Clans with specified ID from database.
            $clans = ClanRepository::build()->findByID($id);

            //check if a Clan is available.
            if (count($clans)) {
                $clan = $clans[0];

                //load all Member and Teams of the Clan.
                $view->setVar('clan_member', UserRepository::build()->findByClan($clan));
                $view->setVar('clan_teams', TeamRepository::build()->findByClan($clan));
            } else {
                $this->redirect(URL.'clan/create');
            }
        }

        //load the view.
        $view->setVar('clan', $clan);
        $view->setVar('backend', true);
        $view->load();
    }

    /**
     * The add Member action of the Clan.
     * @param int $id The ID of the Clan to which the Members would added.
     * @since 0.0.1-dev
     */
    public function memberAdd($id)
    {
        //load the needed session.
        $this->needSession();

        //check if the ID of the Clan is available.
        if (is_numeric($id) && ($id > 0)) {

            //get the Members which will be assigned to the Clan.
            $options = ['flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE];
            $members = filter_input(INPUT_POST, 'members', FILTER_DEFAULT, $options);

            //check if a Member was found.
            if (($members !== false) && (count($members) > 0)) {
                $clans = ClanRepository::build()->findByID($id);

                //check if the Clan could be found.
                if (count($clans) === 1) {
                    $clan = $clans[0];

                    //find all Members which should be assigend with the Clan.
                    $users = UserRepository::build()->findByID($members);

                    //check if Members are available.
                    if (count($users) > 0) {
                        $clanService = new ClanService();

                        //run through all Members to assign with the Clan.
                        foreach ($users as $user) {
                            if ($user instanceof User) {
                                $clanService->addUser($clan, $user);
                            }
                        }
                    }

                    //redirect to the edit view of the Clan.
                    $this->redirect(URL.'clan/edit/'.$clan->id);
                }
            }
        }

        //redirect to the overview of the Clan.
        $this->redirect(URL.'clan');
    }

    /**
     * The organize Member action of the Clan.
     * @param int $id The ID of the Clan which Members would be organized.
     * @since 0.0.1-dev
     */
    public function memberOrganize($id)
    {
        //get the session.
        $this->needSession();

        //get all Users from database.
        $userRepository = UserRepository::build();
        $users = $userRepository->findAll();

        //initialize a new Clan.
        $clan = new Clan();
        $clanMembers = [];

        //check if the ID is available.
        if (is_numeric($id) && ($id > 0)) {
            $clans = ClanRepository::build()->findByID($id);

            //check if a Clan is available.
            if (count($clans) === 1) {
                $clan = $clans[0];
                $clanMembers = $userRepository->findByClan($clan);
            } else {
                $this->redirect(URL.'clan');
                return;
            }
        }

        //get the difference of the Members.
        $users = array_udiff(
            $users,
            $clanMembers,
            function ($objA, $objB) {
                return $objA->id - $objB->id;
            }
        );

        //initialize the and load the view.
        $view = new View('Clan', 'OrganizeMember');
        $view->setVar('backend', true);
        $view->setVar('clan', $clan);
        $view->setVar('users', $users);
        $view->setVar('members', $clanMembers);
        $view->load();
    }

    /**
     * The remove Member action of the Clan.
     * @param int $id The ID of the Clan to which the Members would removed.
     * @since 0.0.1-dev
     */
    public function memberRemove($id)
    {
        //load the needed session.
        $this->needSession();

        //check if the ID of the Clan is available.
        if (is_numeric($id) && ($id > 0)) {

            //get the Members which will be removed.
            $options = ['flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE];
            $members = filter_input(INPUT_POST, 'members', FILTER_DEFAULT, $options);

            //check if a Member was found.
            if (($members !== false) && (count($members) > 0)) {
                $clans = ClanRepository::build()->findByID($id);

                //check if the Clan could be found.
                if (count($clans) === 1) {
                    $clan = $clans[0];

                    //find all Members which should be assigned with the Clan.
                    $users = UserRepository::build()->findByID($members);

                    //check if Members are available.
                    if (count($users) > 0) {
                        $clanService = new ClanService();

                        //run through all Members to assign with the Clan.
                        foreach ($users as $user) {
                            if ($user instanceof User) {
                                $clanService->removeUser($clan, $user);
                            }
                        }
                    }

                    //redirect to the edit view of the Clan.
                    $this->redirect(URL.'clan/edit/'.$clan->id);
                }
            }
        }

        //redirect to the overview of the Clan.
        $this->redirect(URL.'clan');
    }

    /**
     * The save action of the Clan.
     * @return bool The state if the Clan could be successfully saved.
     * @since 0.0.1-dev
     */
    public function save()
    {
        //get the session.
        $this->needSession();

        //get the information from POST.
        $clan = new Clan();
        $clan->loadFromPOST('clan_');

        //get the DataMapper.
        $clanMapper = ClanMapper::build();

        //check if the name is valid.
        if ((new IsValidName())->isSatisfiedBy($clan) === false) {
            $this->jsonOutput('The name is not valid!', 'clan_name', LogLevel::ERROR);
            return false;
        }

        //check if the tag is valid.
        if ((new IsValidTag())->isSatisfiedBy($clan) === false) {
            $this->jsonOutput('The tag is not valid!', 'clan_tag', LogLevel::ERROR);
            return false;
        }

        //check if the website is valid.
        if ((new IsValidWebsite())->isSatisfiedBy($clan) === false) {
            $this->jsonOutput('The website is not valid!', 'clan_website', LogLevel::ERROR);
            return false;
        }

        //check if the Clan already exists.
        if ((new IsUnique($clan->id > 0))->isSatisfiedBy($clan) === false) {
            $this->jsonOutput('The Clan already exists!', '', LogLevel::ERROR);
            return false;
        }

        //save the Clan on the database.
        if ($clanMapper->save($clan)) {
            $this->jsonOutput('The Clan was saved successfully!', '', LogLevel::INFO, URL.'clan');
            return true;
        } else {
            $this->jsonOutput('The Clan could not be saved!', '', LogLevel::ERROR);
            return false;
        }
    }

    /**
     * The add Team action of the Clan.
     * @param int $id The ID of the Clan which Teams are to be assigned.
     * @since 0.0.1-dev
     */
    public function teamAdd($id)
    {
        //load the needed session.
        $this->needSession();

        //check if the ID of the Clan is available.
        if (is_numeric($id) && ($id > 0)) {

            //get the Teams which will be added.
            $options = ['flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE];
            $teams = filter_input(INPUT_POST, 'teams', FILTER_DEFAULT, $options);

            //check if Teams was found.
            if (($teams !== false) && (count($teams) > 0)) {
                $clans = ClanRepository::build()->findByID($id);

                //check if the Clan could be found.
                if (count($clans) === 1) {
                    $clan = $clans[0];

                    //find all Teams which should be assigned with the Clan.
                    $teams = TeamRepository::build()->findByID($teams);

                    //check if Teams are available.
                    if (count($teams) > 0) {
                        $clanService = new ClanService();

                        //run through all Teams to link with the Clan.
                        foreach ($teams as $team) {
                            if ($team instanceof Team) {
                                $clanService->addTeam($clan, $team);
                            }
                        }
                    }

                    //redirect to the edit view of the Clan.
                    $this->redirect(URL.'clan/edit/'.$clan->id);
                }
            }
        }

        //redirect to the overview of the Clan.
        $this->redirect(URL.'clan');
    }

    /**
     * The organize Teams action of the Clan.
     * @param int $id The ID of the Clan which Teams would be organized.
     * @since 0.0.1-dev
     */
    public function teamOrganize($id)
    {
        //get the session.
        $this->needSession();

        //get all Teams from database.
        $teamRepository = TeamRepository::build();
        $teams = $teamRepository->findAll();

        //initialize a new Clan.
        $clan = new Clan();
        $clanTeams = [];

        //check if the ID is available.
        if (is_numeric($id)) {
            $clans = ClanRepository::build()->findByID($id);

            //check if a Clan is available.
            if (count($clans) === 1) {
                $clan = $clans[0];
                $clanTeams = $teamRepository->findByClan($clan);
            } else {
                $this->redirect(URL.'clan');
                return;
            }
        }

        //get the difference of the Teams.
        $teams = array_udiff(
            $teams,
            $clanTeams,
            function ($objA, $objB) {
                return $objA->id - $objB->id;
            }
        );

        //initialize the and load the view.
        $view = new View('Clan', 'OrganizeTeams');
        $view->setVar('backend', true);
        $view->setVar('clan', $clan);
        $view->setVar('teams', $teams);
        $view->setVar('clan_teams', $clanTeams);
        $view->load();
    }

    /**
     * The remove Team action of the Clan.
     * @param int $id The ID of the Clan which Teams are to be removed.
     * @since 0.0.1-dev
     */
    public function teamRemove($id)
    {
        //load the needed Session.
        $this->needSession();

        //check if the ID of the Clan is available.
        if (is_numeric($id) && ($id > 0)) {

            //get the Teams which are to be removed.
            $options = ['flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE];
            $teams = filter_input(INPUT_POST, 'teams', FILTER_DEFAULT, $options);

            //check if a Team was found.
            if (($teams !== false) && (count($teams) > 0)) {
                $clans = ClanRepository::build()->findByID($id);

                //check if the Clan could be found.
                if (count($clans) === 1) {
                    $clan = $clans[0];

                    //find all Teams which should be assigend with the Clan.
                    $teams = TeamRepository::build()->findByID($teams);

                    //check if Teams are available.
                    if (count($teams) > 0) {
                        $clanService = new ClanService();

                        //run through all Teams to assign with the Clan.
                        foreach ($teams as $team) {
                            if ($team instanceof Team) {
                                $clanService->removeTeam($clan, $team);
                            }
                        }
                    }

                    //redirect to the edit view of the Clan.
                    $this->redirect(URL.'clan/edit/'.$clan->id);
                }
            }
        }

        //redirect to the overview of the Clan.
        $this->redirect(URL.'clan');
    }
}
