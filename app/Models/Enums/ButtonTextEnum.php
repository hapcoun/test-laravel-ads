<?php

namespace App\Models\Enums;

use ArchTech\Enums\Values;

enum ButtonTextEnum: string
{
    use Values;
    case Watch = 'Watch';
    case Apply = 'Apply';
    case Download = 'Download';
    case MoreInfo = 'More Info';
}
