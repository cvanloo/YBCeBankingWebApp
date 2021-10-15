<?php
namespace Modules\Repositories;

require_once PHP_MODULES.'Repositories/PDOConnectionBase.php';
require_once PHP_MODULES.'Repositories/Interfaces/ITransactionRepository.php';
require_once PHP_MODULES.'Entities/Transaction.php';
require_once PHP_MODULES.'Entities/User.php';

use config\config;

use Modules\Entities\User;

use Modules\Repositories\Interfaces\ITransactionRepository;
use Modules\Entities\Transaction;

use PDO;
use PDOException;

class MariaDbTransactionRepository implements ITransactionRepository
{

    use PDOConnectionBase;

    public function getTransactionById(int $id) : ?Transaction {
        $conn = $this::getConnection();

        $statement = "SELECT * FROM Transactions WHERE id = ?";
        // TODO: Inculde transactions in user; maybe with the help of INNER JOINS?
        //       _outside_ of the repository in a separate controller would
        //       probably be a better idea.
        // SELECT * FROM users INNER JOIN transactions ON users.id =
        // transactions.obligee_id WHERE users.id = 1262;

        $stmt = $conn->prepare($statement);

        try {
            $stmt->execute([$id]);
        } catch (PDOException $pdoEx) {
            return null;
        }

        $transaction_sql = $stmt->fetch();

        $transaction = null;
        if (false !== $transaction_sql) {
            $transaction = Transaction::create()->constructFromSql($transaction_sql);
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

        $transactions_sql = $stmt->fetchAll();

        $transactions = array();
        foreach ($transactions_sql as $transaction_sql) {
            $transactions[] = Transaction::create()->constructFromSql($transaction_sql);
        }

        return $transactions;
    }

    public function findTransactionsWithFilter(array $filter_list) : array {
        $conn = $this::getConnection();

        $statement = "SELECT * FROM Transactions";

        if (count($filter_list) !== 0) {
            $statement .= " WHERE ";

            $iteration = 0;
            foreach ($filter_list as $key => $value) {
                if ($iteration !== 0) {
                    $statement .= "AND ";
                }

                // FIXME: Dirty hack
				if (is_float($value)) {
					$statement .= "{$key} = CAST(:{$key} AS FLOAT)";
				} else {
					$statement .= "{$key} = :{$key} ";
				}

                $iteration++;
            }
        }
        
        $stmt = $conn->prepare($statement);

        try {
            $stmt->execute($filter_list);
        } catch (PDOException $pdoEx) {
            return array();
        }

        $transactions_sql = $stmt->fetchAll();

        $transactions = array();
        foreach ($transactions_sql as $transaction_sql) {
            $transactions[] = Transaction::create()->constructFromSql($transaction_sql);
        }

        return $transactions;
    }

    public function createTransaction(Transaction $transaction) : ?Transaction {
        $conn = $this::getConnection();

        $statement = 
            "INSERT INTO Transactions (amount, title, description, obligee_id, debtor_id, status)
            VALUES (:amount, :title, :description, :obligee_id, :debtor_id, :status)";

        $stmt = $conn->prepare($statement);

        $data = [
            'amount'      => $transaction->amount,
            'title'       => $transaction->title,
            'description' => $transaction->description ?? '', // nullable
            'obligee_id'  => $transaction->obligee_id,
            'debtor_id'   => $transaction->debtor_id,
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
            SET amount = :amount, title = :title, description = :description, obligee_id = :obligee_id,
            debtor_id = :debtor_id, status = :status
            WHERE id = :id";

        $stmt = $conn->prepare($statement);

        $data = [
            'amount'      => $transaction->amount,
            'title'       => $transaction->title,
            'description' => $transaction->description,
            'obligee_id'  => $transaction->obligee_id,
            'debtor_id'   => $transaction->debtor_id,
            'status'      => $transaction->status,
            'id'          => $transaction->id
        ];

        try {
            $stmt->execute($data);
        } catch (PDOException $pdoEx) {
            return null;
        }

        return $this->getTransactionById($transaction->id);
    }

    public function deleteTransactionById(int $id) : bool {
        $conn = $this::getConnection();

        $statement =
            "DELETE FROM Transactions
            WHERE id = ?";

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
