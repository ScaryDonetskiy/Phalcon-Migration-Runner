<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 13:20
 */

namespace Vados\MigrationRunner\migration;

use Phalcon\Db\AdapterInterface;

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
        $this->dbInstance = DbSingleton::getInstance();
    }

    /**
     * @param string $action
     */
    private function safeRun(string $action)
    {
        $this->dbInstance->begin();
        try {
            switch ($action) {
                default:
                case 'up':
                    $this->up();
                    break;
                case 'down':
                    $this->down();
                    break;
            }
            $this->dbInstance->commit();
        } catch (\Exception $e) {
            $this->dbInstance->rollback();
        }
    }

    abstract public function up();

    abstract public function down();
}