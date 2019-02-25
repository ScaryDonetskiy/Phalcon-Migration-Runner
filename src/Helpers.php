<?php

namespace Vados\MigrationRunner;

/**
 * Class Helpers
 */
class Helpers
{
    /**
     * @var bool $value
     * @return string
     */
    public static function boolToString(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}