<?php

namespace App\Enums;

enum WindowName: string
{
    case MAIN = 'main';

    public function getId(): string
    {
        return match ($this) {
            self::MAIN => self::MAIN->value,
        };

    }
}
