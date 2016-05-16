<?php
/**
 * Namespace for all Controller of Clanify.
 * @package Clanify\Controller
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\Database;
use Clanify\Core\Controller;
use Clanify\Core\View;

/**
 * Class InstallController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class InstallController extends Controller
{
    /**
     * The index (default) action of the Installer.
     * @since 0.0.1-dev
     */
    public function index()
    {
        $view = new View('Install');
        $view->load();
    }

    /**
     * The install action of the Installer.
     * @since 0.0.1-dev
     */
    public function install()
    {
        $pdo = Database::getInstance()->getConnection();
        $stm = $pdo->prepare(file_get_contents(ABSPATH.'resource/install.sql'));

        if ($stm->execute()) {
            echo "Installation successful!";
        } else {
            echo "Installation failed!";
        }

        header('Location: '.URL);
    }
}
