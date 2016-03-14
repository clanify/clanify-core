<?php
/**
 * Namespace for all logging output handler of Clanify.
 * @package Clanify\Core\Log\Output
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Log\Output;

/**
 * Class File
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Log\Output
 * @version 0.0.1-dev
 */
class File implements Output
{
    /**
     * The file handler for the file connection.
     * @since 0.0.1-dev
     * @var bool|resource
     */
    private $file = false;

    /**
     * File constructor.
     * @param string $dirname The name of the directory for the log files.
     * @param string $filename The name of the file which should be used to save the log message.
     * @since 0.0.1-dev
     */
    public function __construct($dirname, $filename)
    {
        //normalize the directory.
        $dirname = rtrim($dirname, '\\/');

        //check if the folder exists.
        if (file_exists($dirname) === false) {
            if (mkdir($dirname) === false) {
                throw new \RuntimeException('Unable to create log directory.');
            }
        }

        //create the full path to the log file.
        $logFile = $dirname.DIRECTORY_SEPARATOR.$filename.'.log';

        //open the file to append the log message.
        $this->file = fopen($logFile, 'a');

        //check if the connection to the file is available.
        if ($this->file === false) {
            throw new \RuntimeException('Unable to open file.');
        }
    }

    /**
     * File destructor.
     * @since 0.0.1-dev
     */
    public function __destruct()
    {
        //check if a file handler is available.
        if ($this->file) {
            fclose($this->file);
            $this->file = false;
        }
    }

    /**
     * Method to write the log message to the File.
     * @param string $message The log message which will be written to the output.
     * @return bool The state if the log message was written to the output.
     * @since 0.0.1-dev
     */
    public function write($message)
    {
        return fwrite($this->file, $message);
    }
}
