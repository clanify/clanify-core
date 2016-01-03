<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;
use Clanify\Domain\Entity\Session;

/**
 * Class DashboardController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class DashboardController extends Controller
{
    /**
     * The index (default) action of the Dashboard.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //initialize the session.
        Session::create();

        //get the view.
        $this->includeHeader();
        $this->includeView('Dashboard', 'Index');
        $this->includeFooter();
    }
}
