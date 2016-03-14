<?php
/**
 * Namespace for all logging output handler of Clanify.
 * @package Clanify\Core\Log\Output
 * @since 0.0.1-dev
 */
namespace Clanify\Core\Log\Output;

/**
 * Interface OutputInterface
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core\Log\Output
 * @version 0.0.1-dev
 */
interface Output
{
    /**
     * Method to write the log message to the output.
     * @param string $message The log message which will be written to the output.
     * @return bool The state if the log message was written to the output.
     * @since 0.0.1-dev
     */
    public function write($message);
}
