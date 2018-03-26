<?php

use Phalcon\Db\Adapter\Pdo\Factory;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\MetaData\Memory;
use Vados\MigrationRunner\providers\PathProvider;

require_once __DIR__ . '/../vendor/autoload.php';

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