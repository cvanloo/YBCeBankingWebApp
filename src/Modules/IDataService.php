<?php
namespace Modules;

require_once PHP_MODULES.'Entities/User.php';
require_once PHP_MODULES.'Entities/Transaction.php';

use Modules\Entities\User;
use Modules\Entities\Transaction;

interface IDataService {

    /**
     * Get a user based on its id.
     * 
     * @param int $id Id of the user.
     * @return User The found user or NULL.
     */
    public function getUserById(int $id) : ?User;

    /**
     * Get all users.
     * 
     * @return User[] An array of users.
     */
    public function getUsers() : array;

    /**
     * Get users that match a certain criteria.
     * 
     * @param array $filter_list A key-value pair of properties and their values.
     * @return User[] An array of users.
     */
    public function findUsersWithFilter(array $filter_list) : array;

    /**
     * Create a new user.
     * 
     * @param User $user The user to create.
     * @return User The created user or NULL.
     */
    public function createUser(User $user) : ?User;

    /**
     * Modify a user.
     *
     * @param User $user The modified user.
     * @return User The modified user or NULL.
     */
    public function updateUser(User $user) : ?User;

    /**
     * Delete a user.
     * 
     * @param int $id The id of the user to delete.
     * @return bool True on success.
     */
    public function deleteUserById(int $id) : bool;

    /**
     * Get a transaction based on its id.
     * 
     * @param int $id Id of the transaction.
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
     * Get transactions that match a certain criteria.
     * 
     * @param array $filter_list A key-value pair of properties and their values.
     * @return Transaction[] An array of transactions.
     */
    public function findTransactionsWithFilter(array $filter_list) : array;

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
     * @param int $id The id of the transaction to delete.
     * @return bool True on success.
     */
    public function deleteTransactionById(int $id) : bool;
}

?>