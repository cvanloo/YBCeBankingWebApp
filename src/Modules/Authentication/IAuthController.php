<?php

namespace Modules\Authentication;

require_once PHP_MODULES.'Entities/User.php';

use Modules\Entity\User;

interface IAuthController {

	/**
	 * Register (create) a new user.
	 * 
	 * @param string $email The user's email address.
	 * @param string $username The user's username.
	 * @param string $password The user's (plain-text) password. Will be used to
	 * generate a BCrypt hash.
	 * @return User The newly registered user.
	 * @throws IAuthException
	 */
	public function register(string $email, string $username, string $password) : User;
	
	/**
	 * Authenticate a user.
	 * 
	 * @param string $username The user's username.
	 * @param string $password The user's password.
	 * @throws IAuthException
	 */
	public function login(string $username, string $password) : User;

	/**
	 * Log a user out.
	 * 
	 * @param User $user The user to log out.
	 */
	public function logout(User $user) : void;
}

interface IAuthException { }

?>