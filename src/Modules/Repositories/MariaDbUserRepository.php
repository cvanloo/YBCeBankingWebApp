<?php

namespace Modules\Repositories;

require_once "/home/miya/code/PHP/YBCeBankingWebApp/src/config/config.php";
require_once PHP_MODULES.'Repositories/Interfaces/IUserRepository.php';
require_once PHP_MODULES.'Entities/User.php';

use config\config;
use Modules\Repositories\Interfaces\IUserRepository;
use Modules\Entities\User;

use PDO;
use PDOException;

class MariaDbUserRepository implements IUserRepository {

	private static function getConnection() : PDO {
		try {
			$conn = new PDO(DB_CONNECTION, DB_USER, DB_PASSWD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $pdoEx) {
			echo $pdoEx;
			die("Failed to connect to the database, see error above.");
		}

		return $conn;
	}

	public function getUserById(int $id) : User {
		$conn = $this::getConnection();

		//$conn->beginTransaction();

		$statement = "SELECT * FROM users WHERE id = ?";
		$stmt = $conn->prepare($statement);

		try {
			$stmt->execute([$id]);
		} catch (PDOException $pdoEx) {
			//$conn->rollBack();
			return null;
		}

		//$conn->commit();
		$user_sql = $stmt->fetch();
		var_dump($user_sql);
		return null;
	}

    public function getUsers() : array {}
    public function createUser(User $user) : User {}
    public function updateUser(User $user) : User {}
    public function deleteUser(int $id) : bool {}
}

?>
