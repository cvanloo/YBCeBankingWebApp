<?php
namespace Modules\Entity;

use DateTime;
use Modules\Entity\User;

public class Transaction {
    public Long $id;
    public DateTime $timestamp;
    public string $title;
    public string $description;
    public User $obligee;
    public User $debtor;
    public TransactionState $status;
}

public abstract class TransactionState {
    public const Pending = 0;
    public const Completed = 1;
    public const Cancelled = 2;
}

?>