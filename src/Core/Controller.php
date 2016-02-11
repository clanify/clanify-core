<?php
/**
 * Namespace for all core functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

/**
 * Class Controller
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core
 * @version 0.0.1-dev
 */
class Controller
{
    /**
     * The path to the view directory.
     * @since 0.0.1-dev
     * @var string
     */
    private $viewDirectory = SRCPATH.'View'.DIRECTORY_SEPARATOR;

    /**
     * Method to include the footer file of the template.
     * @since 0.0.1-dev
     */
    protected function includeFooter()
    {
        //get the path of the footer file.
        $footerFile = $this->viewDirectory.'templates/footer.php';

        //check if the footer file exists.
        if (file_exists($footerFile)) {
            include($footerFile);
        }
    }

    /**
     * Method to include the header file of the template.
     * @since 0.0.1-dev
     */
    protected function includeHeader()
    {
        //get the path of the header file.
        $headerFile = $this->viewDirectory.'templates/header.php';

        //check if the header file exists.
        if (file_exists($headerFile)) {
            include($headerFile);
        }
    }

    /**
     * Method to include the view file for the specified controller and method.
     * @param string $controller The controller which will be used.
     * @param string $method The method of the controller which will be used.
     * @since 0.0.1-dev
     */
    protected function includeView($controller, $method)
    {
        //get the path of the view file.
        $viewFile = $this->viewDirectory.$controller.DIRECTORY_SEPARATOR.$method.'View.php';

        //check if the view file exists.
        if (file_exists($viewFile)) {
            include($viewFile);
        }
    }
}
