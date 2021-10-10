<?php

namespace Modules\Entities;

require_once PHP_MODULES.'Entities/Transaction.php';

use Modules\Transaction;

class User {

	public function __construct() { }

	public static function create() { return new self(); }

	public function constructFromSql($sql) {
		$this->id = (int) $sql['id'];
		$this->email = $sql['email'];
		$this->username = $sql['username'];
		$this->passwdhash = $sql['passwdhash'];
		$this->accountbalance = (int) $sql['accountbalance'];
		$this->created = $sql['created'];
		$this->deleted = $sql['deleted'];

		return $this;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}

	public function setPasswdhash($passwdhash) {
		$this->passwdhash = $passwdhash;
		return $this;
	}

	public function setAccountbalance($accountbalance) {
		$this->accountbalance = $accountbalance;
		return $this;
	}

	public function setCreated($created) {
		$this->created = $created;
		return $this;
	}

	public function setDeleted($deleted) {
		$this->deleted = $deleted;
		return $this;
	}

	public function setTransactions($transactions) {
		$this->transactions = $transactions;
		return $this;
	}

	public function __destruct() { }

	public int $id;
	public string $email;
	public string $username;
	public string $passwdhash;
	public int $accountbalance;
	public string $created;
	public bool $deleted;
	public array $transactions; // Transaction[]
}

?>
