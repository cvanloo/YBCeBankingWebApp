<?php
namespace Modules\Repositories;

require_once "/home/miya/code/PHP/YBCeBankingWebApp/src/config/config.php";
require_once PHP_MODULES.'Repositories/Interfaces/ITransactionRepository.php';
require_once PHP_MODULES.'Entities/Transaction.php';

use config\config;
use Modules\Repositories\Interfaces\IUserRepository;
use Modules\Entities\User;

use PDO;
use PDOException;

use Modules\Repositories\Interfaces\ITransactionRepository;
use Modules\Entites\Transaction;

class MariaDbTransactionRepository implements ITransactionRepository {

    public function getTransactionById(int $id) : Transaction {}
    public function getTransactions() : array {}
    public function createTransaction(Transaction $transaction) : Transaction {}
    public function updateTransaction(Transaction $transaction) : Transaction {}
    public function deleteTransaction(int $id) : bool {}
}

?>
