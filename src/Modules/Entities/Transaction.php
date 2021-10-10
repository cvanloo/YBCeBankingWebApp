<?php

namespace Modules\Entites;

require_once PHP_MODULES.'Entities/User.php';

use Modules\Entities\User;

class Transaction {

	public function __construct() { }

	public static function create() { return new self(); }

	public function constructFromSql($sql) {
		$this->id = (int) $sql['id'];
		$this->amount = (int) $sql['amount'];
		$this->created = $sql['created'];
		$this->title = $sql['title'];
		$this->description = $sql['description'];
		$this->obligee = $sql['obligee'];
		$this->debtor = $sql['debtor'];
		$this->status = (int) $sql['status'];

		return $this;
	}

	public function construct($id, $amount, $created, $title, $description,
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

	public int $id;
	public int $amount;
	public string $created;
	public string $title;
	public string $description;
	public User $obligee;
	public User $debtor;
	public TransactionState $status;
}

abstract class TransactionState {
	public const Pending = 0;
	public const Completed = 1;
	public const Cancelled = 2;
}

?>
