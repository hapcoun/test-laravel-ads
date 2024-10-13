<?php

namespace App\Models\Enums;

use ArchTech\Enums\Values;

enum RoleEnum: string
{
    use Values;
    case Admin = 'admin';
    case User = 'user';
}
