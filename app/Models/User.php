<?php

namespace App\Models;

use Corcel\Model\User as BaseUser;
use Laravel\Sanctum\HasApiTokens;

class User extends BaseUser
{
    use HasApiTokens;
}
