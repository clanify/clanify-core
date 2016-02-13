<?php
/**
 * Namespace for all core functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

/**
 * Class View
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core
 * @version 0.0.1-dev
 */
class View
{
    /**
     * The controller which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $controller = '';

    /**
     * The method which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    private $method = '';

    /**
     * An array with all view variables.
     * @since 0.0.1-dev
     * @var array
     */
    private $viewVars = [];

    /**
     * View constructor.
     * @param string $controller The name of the controller.
     * @param string $method The name of the method.
     * @since 0.0.1-dev
     */
    public function __construct($controller, $method = 'Index')
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * Method to get a variable of the View.
     * @param string $name The name of the variable.
     * @param mixed $default The default value of the variable if not set.
     * @return mixed The value of the view variable.
     * @since 0.0.1-dev
     */
    public function getVar($name, $default = null)
    {
        return (isset($this->viewVars[$name])) ? $this->viewVars[$name] : $default;
    }

    /**
     * Method to include the footer file of the template.
     * @since 0.0.1-dev
     */
    private function includeFooter()
    {
        //get the path of the footer file.
        $footerFile = VIEWDIR.'templates/footer.php';

        //check if the footer file exists.
        if (file_exists($footerFile)) {
            include($footerFile);
        }
    }

    /**
     * Method to include the header file of the template.
     * @since 0.0.1-dev
     */
    private function includeHeader()
    {
        //get the path of the header file.
        $headerFile = VIEWDIR.'templates/header.php';

        //check if the header file exists.
        if (file_exists($headerFile)) {
            include($headerFile);
        }
    }

    /**
     * Method to include the view file for the specified controller and method.
     * @since 0.0.1-dev
     */
    private function includeView()
    {
        //get the path of the view file.
        $viewFile = VIEWDIR.$this->controller.DIRECTORY_SEPARATOR.$this->method.'View.php';

        //check if the view file exists.
        if (file_exists($viewFile)) {
            include($viewFile);
        }
    }

    /**
     * Method to load the view files for the specified controller and method.
     * @since 0.0.1-dev
     */
    public function load()
    {
        $this->includeHeader();
        $this->includeView();
        $this->includeFooter();
    }

    /**
     * Method to set a variable to the view.
     * @param string $name The name of the variable.
     * @param mixed $value The value of the variable.
     * @since 0.0.1-dev
     */
    public function setVar($name, $value)
    {
        $this->viewVars[$name] = $value;
    }
}
