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

class MariaDbUserRepository implements IUserRepository
{

	use PDOConnectionBase;

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

		$users_sql = $stmt->fetchAll();

		$users = array();
		foreach ($users_sql as $user_sql) {
			$users[] = User::create()->constructFromSql($user_sql);
		}

		return $users;
	}

	public function findUsersWithFilter(array $filter_list) : array {
		$conn = $this::getConnection();

		$statement = "SELECT * FROM users";

		if (count($filter_list) !== 0) {
			$statement .= " WHERE ";

			$iteration = 0;
			foreach ($filter_list as $key => $value) {
				if ($iteration !== 0) {
					$statement .= "AND ";
				}

				// FIXME: Dirty hack
				if (is_float($value)) {
					$statement .= "{$key} = CAST(:{$key} AS FLOAT)";
				} else {
					$statement .= "{$key} = :{$key} ";
				}

				$iteration++;
			}
		}

		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute($filter_list);
		} catch (PDOException $pdoEx) {
			return array();
		}

		$transactions_sql = $stmt->fetchAll();

		$transactions = array();
		foreach ($transactions_sql as $transaction_sql) {
			$transactions[] = User::create()->constructFromSql($transaction_sql);
		}

		return $transactions;
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
			'deleted'        => (int) $user->deleted,
			'id'             => $user->id
		];

		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute($data);
		} catch (PDOException $pdoEx) {
			return null;
		}

		return $this->getUserById($user->id);
	}

	public function deleteUserById(int $id) : bool {
		$conn = $this::getConnection();

		$statement =
			"DELETE FROM users
			WHERE id = ?";

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
