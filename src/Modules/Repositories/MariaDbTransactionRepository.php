<?php
namespace Modules\Repositories;

require_once PHP_MODULES.'Repositories/PDOConnectionBase.php';
require_once PHP_MODULES.'Repositories/Interfaces/ITransactionRepository.php';
require_once PHP_MODULES.'Entities/Transaction.php';

use config\config;
use Modules\Repositories\Interfaces\IUserRepository;
use Modules\Entities\User;

use PDO;
use PDOException;

use Modules\Repositories\Interfaces\ITransactionRepository;
use Modules\Entites\Transaction;

class MariaDbTransactionRepository
	extends PDOConnectionBase
	implements ITransactionRepository
{

    public function getTransactionById(int $id) : ?Transaction {
        $conn = $this::getConnection();

        $statement = "SELECT * FROM Transactions WHERE id = ?";

        $stmt = $conn->prepare($statement);

        try {
            $stmt->execute([$id]);
        } catch (PDOException $pdoEx) {
            return null;
        }

        $transaction_sql = $stmt->fetch();

        $transaction = null;
        if (false !== $transaction_sql) {
            $transaction = Transaction()::create()->constructFromSql($transaction_sql);
        }

        return $transaction;
    }

    public function getTransactions() : array {
        $conn = $this::getConnection();

        $statement = "SELECT * FROM Transactions";
        
        $stmt = $conn->prepare($statement);

        try {
            $stmt->execute();
        } catch (PDOException $pdoEx) {
            return array();
        }

        $transactions_sql = $stmt->fetch();

        $transactions = array();
        foreach ($transactions_sql as $transaction_sql) {
            $transactions[] = Transaction::create()->constructFromSql($transaction_sql);
        }

        return $transactions;
    }

    public function createTransaction(Transaction $transaction) : ?Transaction {
        $conn = $this::getConnection();

        $statement = 
            "INSERT INTO Transactions (amount, title, description, obligee, debtor, status)
            VALUES (:amount, :title, :description, :obligee, :debtor, :status)";

        $stmt = $conn->prepare($statement);

        $data = [
            'amount'      => $transaction->amount,
            'title'       => $transaction->title,
            'description' => $transaction->description,
            'obligee'     => $transaction->obligee,
            'debtor'      => $transaction->debtor,
            'status'      => $transaction->status,
        ];

        try {
            $stmt->execute($data);
        } catch (PDOException $pdoEx) {
            return null;
        }

        return $this->getTransactionById($conn->lastInsertId());
    }

    public function updateTransaction(Transaction $transaction) : ?Transaction {
        $conn = $this::getConnection();

        $statement = 
            "UPDATE Transactions
            SET amount = :amount, title = :title, description = :description, obligee = :obligee,
            debtor = :debtor, status = :status
            WHERE id = :id";

        $stmt = $conn->prepare($statement);

        $data = [
            'amount'      => $transaction->amount,
            'title'       => $transaction->title,
            'description' => $transaction->description,
            'obligee'     => $transaction->obligee,
            'debtor'      => $transaction->debtor,
            'status'      => $transaction->status,
        ];

        try {
            $stmt->execute($data);
        } catch (PDOException $pdoEx) {
            return null;
        }

        return $this->getTransactionById($conn->lastInsertId());
    }

    public function deleteTransaction(int $id) : bool {
        $conn = $this::getConnection();

        $statement =
            "DELETE FROM Transactions
            WHERE id = :id";

        $stmt = $conn->prepare($statement);

        try {
            $stmt->execute([$id]);
        } catch (PDOException) {
            return false;
        }

        return true;
    }
}

?>
