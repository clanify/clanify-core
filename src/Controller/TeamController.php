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
use Clanify\Domain\DataMapper\TeamMapper;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Repository\TeamRepository;
use Clanify\Domain\Repository\UserRepository;
use Clanify\Domain\Specification\Team\IsUnique;
use Clanify\Domain\Specification\Team\IsValidName;
use Clanify\Domain\Specification\Team\IsValidTag;
use Clanify\Domain\Specification\Team\IsValidWebsite;
use Clanify\Domain\TableMapper\TeamUserTableMapper;

/**
 * Class TeamController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class TeamController extends Controller
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
        $view = new View('Team');
        $view->setVar('teams', TeamRepository::build()->findAll());
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
     * The delete action of the Team.
     * @param int $id The ID of the Team which will be deleted.
     * @since 0.0.1-dev
     */
    public function delete($id)
    {
        //get the session.
        $this->needSession();

        //check if a valid ID is available.
        if (is_numeric($id) && ($id > 0)) {
            $teams = TeamRepository::build()->findByID($id);

            //check if the Team is available.
            if (count($teams) === 1) {
                if (TeamMapper::build()->delete($teams[0])) {
                    $this->redirect(URL.'team');
                } else {
                    $this->redirect(URL.'team/edit/'.$id);
                }
            }
        }

        //redirect to the overview of the Teams.
        $this->redirect(URL.'team');
    }

    /**
     * The edit action of the Team.
     * @param int $id The ID of the Team which will be edit (0 = new team).
     * @since 0.0.1-dev
     */
    public function edit($id = 0)
    {
        //get the session.
        $this->needSession();

        //initialize a new team entity.
        $team = new Team();
        $view = new View('Team', 'Edit');

        //check if a User should be loaded.
        if (is_numeric($id) && ($id > 0)) {

            //find all the teams.
            $teams = TeamRepository::build()->findByID((int) $id);

            //check if a team is available.
            if (count($teams)) {
                $team = $teams[0];

                //load all Member of the Team.
                $view->setVar('team_member', UserRepository::build()->findByTeam($team));
            } else {
                $this->redirect(URL.'team/create');
            }
        }

        $view->setVar('team', $team);
        $view->setVar('backend', true);
        $view->load();
    }

    /**
     * The save action of the Team.
     * @return bool The state if the Team was successfully saved.
     * @since 0.0.1-dev
     */
    public function save()
    {
        //get the session.
        $this->needSession();

        //get the information from post.
        $team = new Team();
        $team->loadFromPOST('team_');

        //check if the name is valid.
        if ((new IsValidName())->isSatisfiedBy($team) === false) {
            $this->jsonOutput('The name is not valid!', 'team_name', LogLevel::ERROR);
            return false;
        }

        //check if the tag is valid.
        if ((new IsValidTag())->isSatisfiedBy($team) === false) {
            $this->jsonOutput('The tag is not valid!', 'team_tag', LogLevel::ERROR);
            return false;
        }

        //check if the website is valid.
        if ((new IsValidWebsite())->isSatisfiedBy($team) === false) {
            $this->jsonOutput('The website is not valid!', 'team_website', LogLevel::ERROR);
            return false;
        }

        //check if the Team already exists.
        if ((new IsUnique(TeamRepository::build()))->isSatisfiedBy($team) === false) {
            $this->jsonOutput('The Team already exists!', '', LogLevel::ERROR);
            return false;
        }

        //save the Team on the database.
        if (TeamMapper::build()->save($team)) {
            $this->jsonOutput('The Team was saved successfully!', '', LogLevel::INFO, URL.'team');
            return true;
        } else {
            $this->jsonOutput('The Team could not be saved!', '', LogLevel::ERROR);
            return false;
        }
    }





    

    public function organizeMember()
    {
        $this->needSession();

        $userRepository = UserRepository::build();
        $users = $userRepository->findAll();

        //get the parameters from the URL.
        $params = func_get_args();

        //initialize a new Team Entity.
        $team = new Team();
        $members = [];

        //check if the ID is available.
        if (isset($params[0]) === true && is_numeric($params[0])) {
            $teams = TeamRepository::build()->findByID($params[0]);

            if (count($teams) === 1) {
                $team = $teams[0];
                $members = $userRepository->findByTeam($team);
            } else {
                $this->redirect(URL.'team');
                return;
            }
        }

        $users = array_udiff(
            $users,
            $members,
            function ($objA, $objB) {
                return $objA->id - $objB->id;
            }
        );

        $view = new View('Team', 'OrganizeMember');
        $view->setVar('backend', true);
        $view->setVar('team', $team);
        $view->setVar('users', $users);
        $view->setVar('members', $members);
        $view->load();
    }

    public function memberRemove()
    {
        //get the team id from the POST.
        $teamID = filter_input(INPUT_POST, 'team_id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        //check if the team id is available.
        if (($teamID !== false) && ($teamID !== null) && (is_numeric($teamID)) && ($teamID > 0)) {

            //get the members which will be removed.
            $options = ['flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE];
            $members = filter_input(INPUT_POST, 'members', FILTER_DEFAULT, $options);

            //check if a member was found.
            if (($members !== false) && (count($members) > 0)) {
                $teams = TeamRepository::build()->findByID($teamID);

                if (count($teams) === 1) {
                    $users = UserRepository::build()->findByID($members);
                    $teamUserTableMapper = TeamUserTableMapper::build();

                    foreach ($users as $user) {
                        $teamUserTableMapper->delete($teams[0], $user);
                    }

                    $this->redirect(URL.'team/edit/'.$teams[0]->id);
                    return;
                }
            }
        }
        $this->redirect(URL.'team');
        return;
    }

    public function memberAdd()
    {
        $teamID = filter_input(INPUT_POST, 'team_id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        //check if the team id is available.
        if (($teamID !== false) && ($teamID !== null) && (is_numeric($teamID)) && ($teamID > 0)) {

            //get the members which will be assigned.
            $options = ['flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE];
            $members = filter_input(INPUT_POST, 'members', FILTER_DEFAULT, $options);

            //check if a member was found.
            if (($members !== false) && (count($members) > 0)) {
                $teams = TeamRepository::build()->findByID($teamID);

                if (count($teams) === 1) {
                    $users = UserRepository::build()->findByID($members);
                    $teamUserTableMapper = TeamUserTableMapper::build();

                    foreach ($users as $user) {
                       $teamUserTableMapper->create($teams[0], $user);
                    }

                    $this->redirect(URL.'team/edit/'.$teams[0]->id);
                    return;
                }
            }
        }
        $this->redirect(URL.'team');
        return;
    }
}
