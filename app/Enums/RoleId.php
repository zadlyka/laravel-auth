<?php
namespace App\Enums;

enum RoleId: int
{
    case SuperAdmin = 1;
    case Admin = 2;
    case Employee = 3;
}