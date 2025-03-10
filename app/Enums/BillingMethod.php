<?php

namespace App\Enums;

enum BillingMethod: string
{
    case HOURLY_JOB_RATE = 'Hourly Job Rate';
    case MONTHLY_JOB_RATE = 'Monthly Job Rate';
}
