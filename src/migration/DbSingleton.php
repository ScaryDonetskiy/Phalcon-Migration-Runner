<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 14:25
 */

namespace Vados\MigrationRunner\migration;

use Phalcon\Db\Adapter\Pdo\Factory;
use Phalcon\Db\AdapterInterface;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class DbSingleton
 * @package Vados\MigrationRunner\migration
 */
class DbSingleton
{
    /**
     * @var \Phalcon\Db\AdapterInterface
     */
    private static $instance;

    /**
     * DbSingleton constructor.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * @return AdapterInterface
     */
    public static function getInstance(): AdapterInterface
    {
        if (empty(self::$instance)) {
            self::$instance = Factory::load(require PathProvider::getConfig());
        }
        return self::$instance;
    }
}