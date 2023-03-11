<?php

namespace App\Enums;

enum ExceptionStatusEnum: string
{
    case Open = 'Open';
    case Read = 'Read';
    case Fixed = 'Fixed';
}
