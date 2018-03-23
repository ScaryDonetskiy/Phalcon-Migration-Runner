<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 13:20
 */

namespace Vados\MigrationRunner\migration;

use Phalcon\Db\AdapterInterface;
use Phalcon\Di;

/**
 * Class Migration
 * @package Vados\MigrationRunner\migration
 */
abstract class Migration
{
    /**
     * @var AdapterInterface
     */
    private $dbInstance;

    /**
     * Migration constructor.
     */
    public function __construct()
    {
        $this->dbInstance = Di::getDefault()->getShared('db');
    }

    /**
     * @param string $action
     * @return bool
     */
    public function safeRun(string $action): bool
    {
        $this->dbInstance->begin();
        try {
            switch ($action) {
                default:
                case 'up':
                    $result = $this->up();
                    break;
                case 'down':
                    $result = $this->down();
                    break;
            }
            if ($result) {
                $this->dbInstance->commit();
            } else {
                $this->dbInstance->rollback();
            }
            return $result;
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            $this->dbInstance->rollback();
            return false;
        }
    }

    /**
     * @return AdapterInterface
     */
    public function getDbConnection(): AdapterInterface
    {
        return $this->dbInstance;
    }

    /**
     * @return bool
     */
    abstract public function up(): bool;

    /**
     * @return bool
     */
    abstract public function down(): bool;
}