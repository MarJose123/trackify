<?php

namespace App\Enums;

enum CurrencyCode: string
{
    case PHP = 'PHP';
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case AUD = 'AUD';

    public function getCurrencySymbol(): string
    {
        return match ($this) {
            self::PHP => 'Php',
            self::USD, self::AUD => '$',
            self::EUR => '€',
            self::GBP => '£',
        };

    }

    public function getCurrencyCode(): string
    {
        return match ($this) {
            self::PHP => self::PHP->value,
            self::USD => self::USD->value,
            self::EUR => self::EUR->value,
            self::GBP => self::GBP->value,
            self::AUD => self::AUD->value,
        };
    }

    public function getCurrencyName(): string
    {
        return match ($this) {
            self::PHP => 'Philippine Peso',
            self::USD => 'US Dollar',
            self::EUR => 'Euro',
            self::GBP => 'Pound',
            self::AUD => 'Australian Dollar',
        };

    }
}
