<?php

namespace App\Models;

use Corcel\Model\User as BaseUser;
use Laravel\Sanctum\HasApiTokens;

class WpUser extends BaseUser
{
    use HasApiTokens;

    protected $table = 'users';
}
