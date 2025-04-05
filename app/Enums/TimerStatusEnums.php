<?php

namespace App\Enums;

enum TimerStatusEnums: string
{
    case Initiated = 'initiated';
    case Running = 'running';
    case Paused = 'paused';
    case Stopped = 'stopped';

    public function getLabel(): string
    {
        return match ($this) {
            self::Initiated => 'Initiated',
            self::Running => 'Running',
            self::Paused => 'Paused',
            self::Stopped => 'Stopped',
        };
    }
}
