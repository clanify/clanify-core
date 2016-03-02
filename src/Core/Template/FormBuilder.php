<?php
/**
 * Namespace for all template functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Template;

/**
 * Class FormBuilder
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Template
 * @version 0.0.1-dev
 */
class FormBuilder
{
    /**
     * Method to get a "cancel" button with target URL (no submit).
     * @param string $url The URL which will be used as target.
     * @param string $title The title of the "cancel" button.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getButtonCancel($url, $title = 'Cancel')
    {
        return '<a class="btn btn-primary btn-sm" href="'.$url.'"><i class="fa fa-ban"></i>'.$title.'</a>';
    }

    /**
     * Method to get a "delete" button with target URL (no submit).
     * @param string $url The URL which will be used as target.
     * @param string $title The title of the "delete" button.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getButtonDelete($url, $title = 'Delete')
    {
        return '<a class="btn btn-danger btn-sm" href="'.$url.'"><i class="fa fa-trash"></i>'.$title.'</a>';
    }

    /**
     * Method to get a "save" button to submit a form.
     * @param string $title The title of the "save" button.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getButtonSaveForm($title = 'Save')
    {
        return '<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i>'.$title.'</button>';
    }

    /**
     * Method to get a "new" button with target URL (no submit).
     * @param string $url The URL which will be used as target.
     * @param string $title The title of the "new" button.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getButtonNew($url, $title = 'New')
    {
        return '<a class="btn btn-success btn-sm" href="'.$url.'"><i class="fa fa-plus"></i>'.$title.'</a>';
    }

    /**
     * Method to get a "organize" button with target URL (no submit).
     * @param string $url The URL which will be used as target.
     * @param string $title The title of the "organize" button.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getButtonOrganize($url, $title = 'Organize')
    {
        return '<a class="btn btn-success btn-sm" href="'.$url.'"><i class="fa fa-sitemap"></i>'.$title.'</a>';
    }

    /**
     * Method to get a input element with a datepicker to select a date.
     * @param string $name The name of the input element.
     * @param string $placeholder The placeholder value to show a default value.
     * @param string $value The value which should be visible on the input.
     * @return string The HTML markup for input with datepicker.
     * @since 0.0.1-dev
     */
    public static function getInputDatepicker($name, $placeholder, $value = '')
    {
        $html = '<div class="form-group">';
        $html .= '<div class="input-group date" data-provide="datepicker">';
        $html .= '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" ';
        $html .= 'placeholder="'.$placeholder.'" value="'.$value.'">';
        $html .= '<div class="input-group-addon primary"><span class="fa fa-calendar"></span></div>';
        $html .= '</div></div>';
        $html .= '<script>enableDatepicker("#'.$name.'")</script>';
        return $html;
    }

    /**
     * Method to get a input element of type hidden.
     * @param string $name The name of the input element.
     * @param string $value The value which should be visible to the input.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getInputHidden($name, $value = '')
    {
        return '<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
    }

    /**
     * Method to get a input element of type password.
     * @param string $name The name of the input element.
     * @param string $placeholder The placeholder value to show a default value.
     * @param string $value The value which should be visible on the input.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getInputPassword($name, $placeholder, $value = '')
    {
        $html = '<label  class="sr-only" for="'.$name.'">'.$placeholder.'</label>';
        $html .= '<div class="form-group">';
        $html .= '<input type="password" class="form-control" id="'.$name.'" name="'.$name.'" ';
        $html .= 'placeholder="'.$placeholder.'" value="'.$value.'"/>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Method to get a input element of type text.
     * @param string $name The name of the input element.
     * @param string $placeholder The placeholder value to show a default value.
     * @param string $value The value which should be visible on the input.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getInputText($name, $placeholder, $value = '')
    {
        $html = '<label class="sr-only" for="'.$name.'">'.$placeholder.'</label>';
        $html .= '<div class="form-group">';
        $html .= '<input type="text" class="form-control" id="'.$name.'" name="'.$name.'" ';
        $html .= 'placeholder="'.$placeholder.'" value="'.$value.'"/>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Method to get a select element for the genders.
     * @param string $name The name of the select element.
     * @param string $value The value which should be visible on the select.
     * @return string The HTML markup for output.
     * @since 0.0.1-dev
     */
    public static function getSelectGender($name, $value = '')
    {
        //the options of the select.
        $genders = [0 => ['title' => 'Female', 'value' => 'F'], 1 => ['title' => 'Male', 'value' => 'M']];

        //create the html output.
        $html = '<div class="form-group">';
        $html .= '<select name="'.$name.'" class="form-control">';

        //create the options from the array.
        foreach ($genders as $gender) {
            $html .= '<option value="'.$gender['value'].'" '.(($value == $gender['value']) ? 'selected' : '').'>';
            $html .= $gender['title'].'</option>';
        }

        //close the select and return the html output.
        $html .= '</select></div>';
        return $html;
    }
}
