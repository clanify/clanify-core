<?php
/**
 * Namespace for all template functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Template;

/**
 * Class CDN
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Template
 * @version 0.0.1-dev
 */
class CDN
{
    /**
     * Method to get the CSS of Animate.
     * @return string The link to the Animate CSS file.
     * @see https://daneden.github.io/animate.css/
     * @since 0.0.1-dev
     */
    public static function getAnimateCSS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css';
    }

    /**
     * Method to get the CSS of Bootstrap.
     * @return string The link to the Bootstrap CSS file.
     * @see http://getbootstrap.com/
     * @since 0.0.1-dev
     */
    public static function getBootstrapCSS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css';
    }

    /**
     * Method to get the JS of Bootstrap.
     * @return string The link to the Bootstrap JS file.
     * @see http://getbootstrap.com/
     * @since 0.0.1-dev
     */
    public static function getBootstrapJS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js';
    }

    /**
     * Method to get the CSS of Bootstrap Datepicker.
     * @return string The link to the Bootstrap Datepicker CSS file.
     * @see https://bootstrap-datepicker.readthedocs.org/
     * @since 0.0.1-dev
     */
    public static function getBootstrapDatepickerCSS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.min.css';
    }

    /**
     * Method to get the JS of Bootstrap Datepicker.
     * @return string The link to the Bootstrap Datepicker JS file.
     * @see https://bootstrap-datepicker.readthedocs.org/
     * @since 0.0.1-dev
     */
    public static function getBootstrapDatepickerJS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js';
    }

    /**
     * Method to get the CSS of Font-Awesome.
     * @return string The link to the Font-Awesome CSS file.
     * @see https://fortawesome.github.io/Font-Awesome/
     * @since 0.0.1-dev
     */
    public static function getFontAwesomeCSS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css';
    }

    /**
     * Method to get the CSS of Nunito.
     * @return string The link to the Nunito CSS file.
     * @see http://www.fontsquirrel.com/fonts/nunito
     * @since 0.0.1-dev
     */
    public static function getFontNunitoCSS()
    {
        return 'http://fonts.googleapis.com/css?family=Nunito:400,300,700';
    }

    /**
     * Method to get the JS of jQuery.
     * @return string The link to the jQuery JS file.
     * @see https://jquery.com/
     * @since 0.0.1-dev
     */
    public static function getJQueryJS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js';
    }

    /**
     * Method to get the CSS of Normalize.
     * @return string The link to the Normalize CSS file.
     * @see http://necolas.github.com/normalize.css/
     * @since 0.0.1-dev
     */
    public static function getNormalizeCSS()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css';
    }
}
