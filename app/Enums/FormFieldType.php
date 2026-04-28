<?php

namespace App\Enums;

enum FormFieldType: int
{
    case Text = 1;
    case Number = 2;
    case Date = 3;
    case Textarea = 4;
    case Select = 5;
}
