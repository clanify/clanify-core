<?php
/**
 * Namespace for testing Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Test;

use \PHPUnit_Extensions_Database_DB_IDatabaseConnection as IDatabaseConnection;
use \PHPUnit_Extensions_Database_DataSet_IDataSet as IDataSet;

/**
 * Class PHPUnit_Extensions_Database_Operation_MySQL55Truncate
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @version 0.0.1-dev
 */
class MySQL55Truncate extends \PHPUnit_Extensions_Database_Operation_Truncate
{
    /**
     * The method to execute a dataset.
     * @param IDatabaseConnection $connection The connection.
     * @param IDataSet $dataSet The dataset which will be executed.
     * @throws \Exception
     * @since 0.0.1-dev
     */
    public function execute(IDatabaseConnection $connection, IDataSet $dataSet)
    {
        $connection->getConnection()->query("SET @PHAKE_PREV_foreign_key_checks = @@foreign_key_checks");
        $connection->getConnection()->query("SET foreign_key_checks = 0");
        parent::execute($connection, $dataSet);
        $connection->getConnection()->query("SET foreign_key_checks = @PHAKE_PREV_foreign_key_checks");
    }
}
