<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;
use Clanify\Core\View;

/**
 * Class DashboardController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
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
        //load the needed session.
        $this->needSession();

        //get and load the View.
        $view = new View('Dashboard');
        $view->setVar('backend', true);
        $view->load();
    }
}
