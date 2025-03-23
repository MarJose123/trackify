<?php

namespace App\Enums;

enum DefaultWindowSize: int
{
    case DEFAULT_MIN_HEIGHT = 675;
    case DEFAULT_MAX_HEIGHT = 695;
    case DEFAULT_MIN_WIDTH = 1080;
    case DEFAULT_MAX_WIDTH = 1285;

    public function getSize(): int
    {
        return match ($this) {
            DefaultWindowSize::DEFAULT_MIN_WIDTH => self::DEFAULT_MIN_WIDTH->value,
            DefaultWindowSize::DEFAULT_MIN_HEIGHT => self::DEFAULT_MIN_HEIGHT->value,
            DefaultWindowSize::DEFAULT_MAX_WIDTH => self::DEFAULT_MAX_WIDTH->value,
            DefaultWindowSize::DEFAULT_MAX_HEIGHT => self::DEFAULT_MAX_HEIGHT->value,
        };
    }
}
