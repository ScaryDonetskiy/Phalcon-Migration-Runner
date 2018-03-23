<?php

namespace Vados\MigrationRunner\Tests;

use Phalcon\Db\Adapter\Pdo\Factory;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\MetaData\Memory;
use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class BaseTestCase
 * @package Vados\MigrationRunner\Tests
 */
class BaseTestCase extends TestCase
{
    public function setUp()
    {
        file_put_contents(PathProvider::getConfig(), '<?php return ' . var_export([
                'adapter' => 'sqlite',
                'dbname' => 'test.db'
            ], true) . ';');
        $di = Di::getDefault();
        if ($di === null) {
            $di = new Di();
        }
        $di->setShared('db', function () {
            return Factory::load(require PathProvider::getConfig());
        });
        $di->set('modelsManager', new Manager());
        $di->set('modelsMetadata', new Memory());
    }
}