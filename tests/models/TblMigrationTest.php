<?php

namespace Vados\MigrationRunner\Tests\models;

use Phalcon\Db\Adapter\Pdo\Factory;
use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\MetaData\Memory;
use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\models\TblMigration;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class TblMigrationTest
 * @package Vados\MigrationRunner\Tests\models
 */
class TblMigrationTest extends TestCase
{
    /**
     * @var TblMigration
     */
    private $instance;

    public function setUp()
    {
        $di = Di::getDefault();
        if ($di === null) {
            $di = new Di();
        }
        $di->setShared('db', function () {
            return Factory::load(require PathProvider::getConfig());
        });
        $di->set('modelsManager', new Manager());
        $di->set('modelsMetadata', new Memory());

        $this->instance = new TblMigration();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Model::class, $this->instance);
    }

    public function testSetAndGetMigration()
    {
        $this->instance->setMigration('my_migration');
        $this->assertEquals('my_migration', $this->instance->getMigration());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetId()
    {
        $id = new \ReflectionProperty($this->instance, 'id');
        $id->setAccessible(true);
        $id->setValue($this->instance, 1);
        $this->assertEquals(1, $this->instance->getId());
    }
}