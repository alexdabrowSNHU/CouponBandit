<?php

namespace App\Enums;

enum DealType: string
{
    case BOGO = 'bogo';
    case DOLLAR_OFF = '$ off';
    case PERCENT_OFF = '% off';
    case CASHBACK = 'cashback';
}
