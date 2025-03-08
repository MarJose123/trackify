<?php

namespace App\Enums;

enum DefaultWindowSize: int
{
    case HEIGHT = 675;
    case WIDTH = 1060;

    public function getSize(): int
    {
        return match ($this) {
            DefaultWindowSize::WIDTH => self::WIDTH->value,
            DefaultWindowSize::HEIGHT => self::HEIGHT->value,
        };
    }
}
