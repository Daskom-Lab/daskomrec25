<?php
// app/Enums/StageEnum.php

namespace App\Enums;

enum StageEnum: string
{
    case Administration = 'Administration';
    case CodingWritingTest = 'Coding & Writing Test';
    case Interview = 'Interview';
    case GroupingTask = 'Grouping Task';
    case TeachingTest = 'Teaching Test';
    case Upgrading = 'Upgrading';

    /**
     * Get all stages as an array.
     */
    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
