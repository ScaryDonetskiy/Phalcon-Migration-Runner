<?php

namespace Vados\MigrationRunner\enum;

/**
 * Class Command
 * @package Vados\MigrationRunner\enum
 */
abstract class Command
{
    const HELP = 'help';
    const CREATE = 'create';
    const UP = 'up';
    const DOWN = 'down';
}