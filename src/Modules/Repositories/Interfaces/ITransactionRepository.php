<?php

namespace Modules\Repositories\Interfaces;

require_once PHP_MODULES.'Entities/Transaction.php';

use Modules\Entities\Transaction;

/**
 * Repository pattern interface for the Transaction entity.
 */
interface ITransactionRepository {
    /**
     * Get a transaction based on its id.
     * 
     * @param Long $id Id of the transaction.
     * @return Transaction The found transaction or NULL.
     */
    public function getTransactionById(int $id) : ?Transaction;

    /**
     * Get all transactions.
     * 
     * @return Transaction[] An arary of transactions.
     */
    public function getTransactions() : array;

    /**
     * Create a new transaction
     * 
     * @param Transaction $transaction The transaction to create.
     * @return Transaction The created transaction or NULL.
     */
    public function createTransaction(Transaction $transaction) : ?Transaction;

    /**
     * Modify a transaction
     * 
     * @param Transaction $transaction The modified transaction.
     * @return Transaction The modified transaction or NULL.
     */
    public function updateTransaction(Transaction $transaction) : ?Transaction;

    /**
     * Delete a transaction
     * 
     * @param Long $id The id of the transaction to delete.
     * @return bool True on success.
     */
    public function deleteTransaction(int $id) : bool;
}

?>
