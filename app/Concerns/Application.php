<?php

namespace App\Concerns;

use App\Models\User;

trait Application
{
    public function isFirstInstalled(): bool
    {
        // confirming by having no user available
        return User::count() === 0;
    }
}
