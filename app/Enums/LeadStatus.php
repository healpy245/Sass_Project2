<?php

namespace App\Enums;

enum LeadStatus: string
{
    case New = 'new';
    case Pending = 'pending';
    case Done = 'done';
}
