<?php

namespace Modules\Entites;

require_once PHP_MODULES.'Entities/User.php';

use Modules\Entities\User;

class Transaction {
    public int $id;
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
