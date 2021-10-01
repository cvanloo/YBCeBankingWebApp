<?php
namespace Modules\Entity;

use Modules\Transaction;

public class User {
    public Long $id;
    public string $email;
    public string $username;
    public string $passwdHash;
    public int $accountBalance;
    public Transaction[] transactions;
    public bool $deleted;
}

?>