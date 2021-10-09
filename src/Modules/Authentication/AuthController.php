<?php
namespace Modules\Authentication;

require_once PHP_MODULES.'Entities/User.php';

use Modules\Entity\User;

public static class AuthController {
    public static register(User $user) : User {

    }

    public static login(string $username, string $password) : User {

    }

    public static logout(User $user) : User {

    }
}

?>
