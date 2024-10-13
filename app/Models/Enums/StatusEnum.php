<?php

namespace App\Models\Enums;

use ArchTech\Enums\Values;

enum StatusEnum: string
{
    use Values;
    case Active = 'active';
    case Pending = 'pending';
    case Archive = 'archived';
}
