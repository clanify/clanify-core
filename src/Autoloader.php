<?php
/**
 * Namespace for all classes of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify;

/**
 * Class Autoloader
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify
 * @version 0.0.1-dev
 */
class Autoloader
{
    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     * @since 0.0.1-dev
     * @var array
     */
    private $prefixes = array();

    /**
     * Constructor to register the loader with SPL autoloader stack.
     * @since 0.0.1-dev
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Method to add a directory for a namespace prefix.
     * @param string $prefix The namespace prefix.
     * @param string $dir The directory for the class files in the namespace.
     * @since 0.0.1-dev
     */
    public function addNamespace($prefix, $dir)
    {
        //normalize the prefix and directory.
        $prefix = trim($prefix, '\\').'\\';
        $dir = rtrim($dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        //set the directory to the namespace prefix.
        $this->prefixes[$prefix][] = $dir;
    }

    /**
     * Method to load the class file for a given fully-qualified class name.
     * @param string $class The fully-qualified class name.
     * @return bool|string The file name on success or false on failure.
     * @since 0.0.1-dev
     */
    public function loadClass($class)
    {
        //the current namespace prefix.
        $prefix = $class;

        //walk backwards through the prefix and get the new class and prefix.
        while (($pos = strrpos($prefix, '\\')) !== false) {
            $prefix = substr($class, 0, $pos + 1);
            $relativeClass = substr($class, $pos + 1);

            //try to load the file.
            $file = $this->loadFile($prefix, $relativeClass);

            //check if the file could be loaded.
            if ($file !== false) {
                return $file;
            }

            //remove the trailing seperator for the next iteration.
            $prefix = rtrim($prefix, '\\');
        }

        //no file found.
        return false;
    }

    /**
     * Method to load a file for a namespace prefix and class.
     * @param string $prefix The namespace prefix for the class.
     * @param string $class The name of the class.
     * @return bool|string The file path on success or false on failure.
     * @since 0.0.1-dev
     */
    public function loadFile($prefix, $class)
    {
        //check if a directory is available for prefix.
        if (isset($this->prefixes[$prefix]) === false) {
            return false;
        }

        //run through all directories.
        foreach ($this->prefixes[$prefix] as $dir) {
            $file = $dir.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';

            //check if the file exists.
            if (file_exists($file)) {
                require_once($file);
                return $file;
            }
        }

        //no file found.
        return false;
    }
}
