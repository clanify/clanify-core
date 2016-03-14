<?php
/**
 * Namespace for all logging functions of Clanify.
 * @package Clanify\Core\Log
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Log;

/**
 * Class LoggerAbstract
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Log
 * @version 0.0.1-dev
 */
abstract class LoggerAbstract implements LoggerInterface
{
    /**
     * Method to log an action which must be taken immediately.
     * Example: entire website down, database unavailable, etc.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function alert($message, array $context = [])
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Method to log a critical conditions.
     * Example: application component unavailable, unexpected exception.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function critical($message, array $context = [])
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Method to log debug-level messages.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function debug($message, array $context = [])
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Method to log if the system is unusable.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function emergency($message, array $context = [])
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Method to log error conditions.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function error($message, array $context = [])
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Method to log informational messages.
     * Example: user logs in, sql logs.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function info($message, array $context = [])
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Method to log normal but significant conditions.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function notice($message, array $context = [])
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Method to log warning conditions.
     * Example: use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
     * @param string $message The log message (perhaps with placeholder).
     * @param array $context The values for the message to replace the placeholder.
     * @return string The message with the replaced placeholder.
     * @since 0.0.1-dev
     */
    public function warning($message, array $context = [])
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }
}
