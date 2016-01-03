<?php
/**
 * Namespace for all Controller of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Controller;

/**
 * Class IndexController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class InfoController extends Controller
{
    /**
     * The index (default) action of the Info.
     * @since 0.0.1-dev
     */
    public function index()
    {
        //get the view.
        $this->includeHeader();
        $this->includeView('Info', 'Index');
        $this->includeFooter();
    }
}
