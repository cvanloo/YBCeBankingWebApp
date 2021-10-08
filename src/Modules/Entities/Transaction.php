<?php

namespace Modules\Entites;

use DateTime;
use Modules\Entities\User;

class Transaction {
    public int $id;
    public DateTime $created;
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
