# Phalcon Migration Runner

[![Packagist](https://img.shields.io/packagist/l/vados/phalcon-migration-runner.svg)]()
[![PHP from Packagist](https://img.shields.io/packagist/php-v/vados/phalcon-migration-runner.svg)]()
[![Packagist](https://img.shields.io/packagist/dt/vados/phalcon-migration-runner.svg)]()
![GitHub Issues](https://img.shields.io/github/issues-raw/ScaryDonetskiy/Phalcon-Migration-Runner.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ScaryDonetskiy/Phalcon-Migration-Runner/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ScaryDonetskiy/ScaryDonetskiy/Phalcon-Migration-Runner/?branch=master)
[![Travis CI Status](https://travis-ci.org/ScaryDonetskiy/ScaryDonetskiy/Phalcon-Migration-Runner.svg?branch=master)](https://travis-ci.org/ScaryDonetskiy/ScaryDonetskiy/Phalcon-Migration-Runner)

Works with PHP 7.1+

### Usage ###

You can run command 'migration_runner' for creating and applying or reverting migration to your database.

```bash
./vendor/bin/migration_runner <method>
```

By default, runner call method 'help'.

Available methods
 - help - Show help information
 - create {name} - Create new migration
 - up {runCount=0} - Apply new migrations
 - down {runCount=1} - Revert some migration


In your migrations you should use Phalcon Pdo Adapter provided by method 'getDbConnection'. 
You can find API definition in [Phalcon documentation](https://docs.phalconphp.com/en/3.3/Phalcon_Db_AdapterInterface)
```php
public function up(): bool
{
    $this->getDbConnection()->createTable('foo', null, [
        'columns' => [
            new \Phalcon\Db\Column('bar', [
                'type' => \Phalcon\Db\Column::TYPE_INTEGER
            ])
        ]
    ]);
    
    return true;
}
```

### Example ###

Create migration (For first run runner create config)
```bash
$ ./vendor/bin/migration_runner create new_migration

Enter database adapter (default: sqlite): sqlite
Enter database name (default: phalcon): test.db
Config generated in /my_project/migration_runner.config.php
Migration /my_project/migrations/m1522260172_new_migration.php created!
```

Describe your migration
```php
<?php

use Phalcon\Db\Column;
use Vados\MigrationRunner\migration\Migration;

class m1522260172_new_migration extends Migration
{
    public function up(): bool
    {
        $this->getDbConnection()->createTable('foo', null, [
            'columns' => [
                new Column('bar', [
                    'type' => Column::TYPE_INTEGER
                ])
            ]
        ]);

        return true;
    }

    public function down(): bool
    {
        $this->getDbConnection()->dropTable('foo');
        return true;
    }
}
```

Apply your migration
```bash
$ ./migration_runner up

m1522260172_new_migration.php
Apply the above migrations? (yes|no) [yes]: yes
Migration m1522260172_new_migration.php: true
```

### Installation ###

Use composer for installation
```bash
composer require vados/phalcon-migration-runner
```

### Contribution guidelines ###

* Writing tests
* Code review
* Guidelines accord
