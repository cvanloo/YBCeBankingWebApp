<?php

namespace Modules\Authentication;

require_once PHP_MODULES.'Entities/User.php';

use Modules\Entity\User;

class AuthController {

    public static function register(User $user) : User {

    }

    public static function login(string $username, string $password) : User {

    }

    public static function logout(User $user) : User {

    }
}

?>
