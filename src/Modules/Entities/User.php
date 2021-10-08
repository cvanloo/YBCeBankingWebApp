<?php

namespace Modules\Entities;

use \Date;
use Modules\Transaction;

class User {

	function __construct() {
		
	}

	function __destruct() {

	}

    public int $id;
    public string $email;
    public string $username;
    public string $passwdhash;
    public int $accountbalance;
	public Date $created;
    public bool $deleted;
	public array $transactions; // Transaction[]
}

?>
