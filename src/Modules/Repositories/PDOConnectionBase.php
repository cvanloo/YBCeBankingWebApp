<?php

namespace Modules\Repositories;

use PDO;
use PDOException;

trait PDOConnectionBase {

	protected static function getConnection() : PDO {
		try {
			$conn = new PDO(DB_CONNECTION, DB_USER, DB_PASSWD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $pdoEx) {
			echo $pdoEx;
			die("Failed to connect to the database, see error above.");
		}

		return $conn;
	}
}

?>
