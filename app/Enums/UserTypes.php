<?php

namespace App\Enums;

enum UserTypes:string
{
 case Admin = 'admin';
 case User = 'user';
 case Guest = 'guest';
}
