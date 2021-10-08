<?php
namespace Modules\Entity;

use \Date;
use Modules\Transaction;

class User {
    public Long $id;
    public string $email;
    public string $username;
    public string $passwdhash;
    public int $accountbalance;
	public Date $created;
    public bool $deleted;
	public array $transactions; // Transaction[]
}

?>
