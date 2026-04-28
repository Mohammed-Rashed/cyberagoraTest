<?php

namespace App\Enums;

enum ApprovalRequestStatus: int
{
    case Pending = 1;
    case Approved = 2;
    case Rejected = 3;
    case Withdrawn = 4;
}
