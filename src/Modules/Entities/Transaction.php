<?php

namespace Modules\Entities;

require_once PHP_MODULES.'Entities/User.php';

use Modules\Entities\User;

class Transaction {

	public function __construct() { }

	public static function create() { return new self(); }

	public function constructFromSql($sql) {
		$this->id = (int) $sql['id'];
		$this->amount = (float) $sql['amount'];
		$this->created = $sql['created'];
		$this->title = $sql['title'];
		$this->description = $sql['description'];
		$this->obligee_id = (int) $sql['obligee_id'];
		$this->debtor_id = (int) $sql['debtor_id'];
		$this->status = (int) $sql['status'];

		return $this;
	}

	public function constructFromObject($id, $amount, $created, $title, $description,
		$obligee, $debtor, $status)
	{
		$this->id = $id;
		$this->amount = $amount;
		$this->created = $created;
		$this->title = $title;
		$this->description = $description;
		$this->obligee = $obligee;
		$this->debtor = $debtor;
		$this->status = $status;

		return $this;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}

	public function setCreated($created) {
		$this->created = $created;
		return $this;
	}

	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	public function setObligeeId($obligee_id) {
		$this->obligee_id = $obligee_id;
		return $this;
	}

	public function setObligee($obligee) {
		$this->obligee = $obligee;
		return $this;
	}

	public function setDebtorId($debtor_id) {
		$this->debtor_id = $debtor_id;
		return $this;
	}

	public function setDebtor($debtor) {
		$this->debtor = $debtor;
		return $this;
	}

	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}

	public int $id;
	public float $amount;
	public string $created;
	public string $title;
	public string $description;
	public int $obligee_id;
	//public User $obligee;
	public int $debtor_id;
	//public User $debtor;
	public int $status;

	// public function __toString() : string {
	// 	return $amount + 
	// }
}

abstract class TransactionState {
	public const Pending = 0;
	public const Completed = 1;
	public const Cancelled = 2;
}

?>
