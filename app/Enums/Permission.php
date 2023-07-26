<?php
namespace App\Enums;

enum Permission: int
{
    case ManageAll = 0;

    case ManageRole = 100;
    case CreateRole = 101;
    case ReadRole = 102;
    case UpdateRole = 103;
    case DeleteRole = 104;

    case ManageUser = 200;
    case CreateUser = 201;
    case ReadUser = 202;
    case UpdateUser = 203;
    case DeleteUser = 204;
}