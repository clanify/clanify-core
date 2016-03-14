<?php
/**
 * Namespace for all logging functions of Clanify.
 * @package Clanify\Core\Log
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Log;

use Clanify\Core\Log\Output\Output;

/**
 * Class Logger
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Log
 * @version 0.0.1-dev
 */
class Logger extends LoggerAbstract
{
    /**
     * The output handler to save the log message.
     * @since 0.0.1-dev
     * @var Output|null
     */
    private $output = null;

    /**
     * Logger constructor.
     * @param Output $handler The output handler to save the log message.
     * @since 0.0.1-dev
     */
    public function __construct(Output $handler)
    {
        $this->output = $handler;
    }

    /**
     * Method to replace the placeholder of the log message.
     * @param string $message The log message with the placeholder to replace.
     * @param array $context The array with all values to replace the placeholder.
     * @return string The log message with replaced placeholder.
     * @since 0.0.1-dev
     */
    private function interpolate($message, array $context = [])
    {
        //build a replacement array with braces around the context keys.
        $replace = [];

        //run through all context keys to build the replacement array.
        foreach ($context as $key => $value) {
            $replace['{'.$key.'}'] = $value;
        }

        //interpolate the replacement values into the message and return.
        return strtr($message, $replace);
    }

    /**
     * Method to log with an arbitrary level.
     * @param string $level The level which will be used for logging.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function log($level, $message, array $context = [])
    {
        $message = $this->interpolate($message, $context);
        $message = sprintf('[%s] %s: %s%s', gmdate(FORMAT_DATETIME), strtoupper($level), $message, PHP_EOL);
        $this->output->write($message);
    }
}
