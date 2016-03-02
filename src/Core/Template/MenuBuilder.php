<?php
/**
 * Namespace for all template functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Template;

/**
 * Class MenuBuilder
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Template
 * @version 0.0.1-dev
 */
class MenuBuilder
{
    /**
     * The PDO object to connect with database.
     * @since 0.0.1-dev
     * @var \PDO|null
     */
    private $pdo = null;

    /**
     * MenuBuilder constructor.
     * @param \PDO $pdo The PDO object to connect with database.
     * @since 0.0.1-dev
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Method to get a menu from the database.
     * @param string $category The category of the menu which will be loaded.
     * @return string The HTML content of the menu which can be used on output.
     * @since 0.0.1-dev
     */
    public function getMenu($category)
    {
        //create and set the sql to get the menu.
        $sql = 'SELECT n.title, n.controller, n.action, COUNT(*)-1 AS level FROM ';
        $sql .= '(SELECT * FROM menu WHERE category = :category) AS n, ';
        $sql .= '(SELECT * FROM menu WHERE category = :category) AS p ';
        $sql .= 'WHERE n.lft BETWEEN p.lft AND p.rgt GROUP BY n.lft ORDER BY n.lft';
        $sth = $this->pdo->prepare($sql);

        //bind the parameters to the query.
        $sth->bindParam(':category', $category, \PDO::PARAM_STR);

        //execute the query.
        if ($sth->execute()) {

            //get all results from the database and the count of the items.
            $menuItems = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $countItems = count($menuItems);

            //create the beginning of the menu and reset the level.
            $menuHTML = '<ul class="nav navbar-nav">';
            $lastLevel = -1;

            //run through all menu items to generate the menu.
            for ($i = 0; $i < $countItems; $i++) {
                $item = $menuItems[$i];

                //check if the actual level should be closed.
                if ($item['level'] < $lastLevel) {
                    $menuHTML .= '</ul></li>';
                }

                //check if it is a begining of a sub menu.
                if ($item['level'] == 0 && isset($menuItems[$i + 1]['level']) && $menuItems[$i + 1]['level'] == 1) {

                    //set the beginning of a sub menu.
                    $menuHTML .= '<li class="dropdown">';
                    $menuHTML .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" ';
                    $menuHTML .= 'aria-haspopup="true" aria-expanded="false">'.$item['title'].'<span class="caret">';
                    $menuHTML .= '</span></a><ul class="dropdown-menu">';

                    //set the actual level for the last level.
                    $lastLevel = (int) $item['level'];
                    continue;
                } else {

                    //set the menu item which is clickable.
                    $url = URL.$item['controller'].'/'.$item['action'];
                    $menuHTML .= '<li><a href="'.$url.'">'.$item['title'].'</a></li>';

                    //set the actual level for the last level.
                    $lastLevel = $item['level'];
                    continue;
                }
            }

            //close the menu and return the whole HTML code.
            $menuHTML .= '</ul></li>';
            $menuHTML .= '</ul>';
            return $menuHTML;
        }

        //return the default.
        return '';
    }
}
