<?php
/**
 * Namespace for all Logging functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Log;

/**
 * Class LogLevel
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Log
 * @see http://tools.ietf.org/html/rfc5424
 * @version 0.0.1-dev
 */
class LogLevel
{
    /**
     * The alert log level (action must be taken immediately).
     * @const ALERT - action must be taken immediately.
     * @since 0.0.1-dev
     */
    const ALERT = 'alert';

    /**
     * The critical log level (critical conditions).
     * @const CRITICAL - critical conditions.
     * @since 0.0.1-dev
     */
    const CRITICAL = 'critical';

    /**
     * The debug log level (debug-level messages).
     * @const DEBUG - debug-level messages.
     * @since 0.0.1-dev
     */
    const DEBUG = 'debug';

    /**
     * The emergency log level (system is unusable).
     * @const EMERGENCY - system is unusable.
     * @since 0.0.1-dev
     */
    const EMERGENCY = 'emergency';

    /**
     * The error log level (error conditions).
     * @const ERROR - error conditions.
     * @since 0.0.1-dev
     */
    const ERROR = 'error';

    /**
     * The info log level (informational messages).
     * @const INFO - informational messages.
     * @since 0.0.1-dev
     */
    const INFO = 'info';

    /**
     * The notice log level (normal but significant condition).
     * @const NOTICE - normal but significant condition.
     * @since 0.0.1-dev
     */
    const NOTICE = 'notice';

    /**
     * The warning log level (warning conditions).
     * @const WARNING - warning conditions.
     * @since 0.0.1-dev
     */
    const WARNING = 'warning';
}
