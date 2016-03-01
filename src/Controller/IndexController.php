<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;
use Clanify\Core\View;

/**
 * Class IndexController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class IndexController extends Controller
{
    /**
     * The index (default) action of the Index.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //get and load the View.
        $view = new View('Index');
        $view->load();
    }
}
