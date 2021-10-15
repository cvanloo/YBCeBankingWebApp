<?php

namespace Modules\Authentication;

require_once PHP_MODULES.'Entities/User.php';

use Modules\Entity\User;

class AuthController {

    public function register(string $email, string $username, string $password) : User {
        $passwdhash = null; // TODO: Create BCrypt hash.

        $user = User::create()
            ->setEmail($email)
            ->setUsername($username)
            ->setPassword($passwdhash);
    }

    public function login(string $username, string $password) : User {

    }

    public function logout(User $user) : void {

    }
}

class AuthException extends Exception implements IAuthException {

}

?>
