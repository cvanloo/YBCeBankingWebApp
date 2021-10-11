<?php

namespace Modules\Repositories;

require_once PHP_MODULES.'Repositories/PDOConnectionBase.php';
require_once PHP_MODULES.'Repositories/Interfaces/IUserRepository.php';
require_once PHP_MODULES.'Entities/User.php';

use config\config;
use Modules\Repositories\Interfaces\IUserRepository;
use Modules\Entities\User;

use PDO;
use PDOException;

class MariaDbUserRepository
	extends PDOConnectionBase
	implements IUserRepository
{

	public function getUserById(int $id) : ?User {
		$conn = $this::getConnection();

		$statement = "SELECT * FROM users WHERE id = ?";
		
		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute([$id]);
		} catch (PDOException $pdoEx) {
			return null;
		}

		$user_sql = $stmt->fetch();

		$user = null;
		if (false !== $user_sql) {
			$user = User::create()->constructFromSql($user_sql);
		}

		return $user;
	}

	public function getUsers() : array {
		$conn = $this::getConnection();

		$statement = "SELECT * FROM users";

		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute();
		} catch (PDOException $pdoEx) {
			return array();
		}

		$users_sql = $stmt->fetch();

		$users = array();
		foreach ($users_sql as $user_sql) {
			$users[] = User::create()->constructFromSql($user_sql);
		}

		return $users;
	}

	public function createUser(User $user) : ?User {
		$conn = $this::getConnection();

		$statement =
			"INSERT INTO users (email, username, passwdhash, accountbalance)
			VALUES (:email, :username, :passwdhash, :accountbalance)";

		$data = [
			'email'          => $user->email,
			'username'       => $user->username,
			'passwdhash'     => $user->passwdhash,
			'accountbalance' => $user->accountbalance,
		];

		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute($data);
		} catch (PDOException $pdoEx) {
			return null;
		}

		return $this->getUserById($conn->lastInsertId());
	}

	public function updateUser(User $user) : ?User {
		$conn = $this::getConnection();

		$statement =
			"UPDATE users
			SET email = :email, username = :username, passwdhash = :passwdhash,
			accountbalance = :accountbalance, deleted = :deleted
			WHERE id = :id";

		$data = [
			'email'          => $user->email,
			'username'       => $user->username,
			'passwdhash'     => $user->passwdhash,
			'accountbalance' => $user->accountbalance,
			'deleted'        => $user->deleted,
		];

		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute($data);
		} catch (PDOException $pdoEx) {
			return null;
		}

		return $this->getUserById($conn->lastInsertId());
	}

	public function deleteUser(int $id) : bool {
		$conn = $this::getConnection();

		$statement =
			"DELETE FROM users
			WHERE id = :id";

		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute([$id]);
		} catch (PDOException $pdoEx) {
			return false;
		}

		return true;
	}
}

?>
