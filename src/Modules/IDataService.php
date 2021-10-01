<?php
namespace Modules;

public interface IDataService {

    /**
     * Get a user based on its id.
     * 
     * @param Long $id Id of the user.
     * @return User The found user or NULL.
     */
    public function getUserById(Long $id) : User;

    /**
     * Get all users.
     * 
     * @return User[] An array of users.
     */
    public function getUsers() : array;

    /**
     * Create a new user.
     * 
     * @param User $user The user to create.
     * @return User The created user or NULL.
     */
    public function createUser(User $user) : User;

    /**
     * Modify a user.
     *
     * @param User $user The modified user.
     * @return User The modified user or NULL.
     */
    public function updateUser(User $user) : User;

    /**
     * Delete a user.
     * 
     * @param Long $id The id of the user to delete.
     * @return bool True on success.
     */
    public function deleteUser(Long $id) : bool;

    /**
     * Get a transaction based on its id.
     * 
     * @param Long $id Id of the transaction.
     * @return Transaction The found transaction or NULL.
     */
    public function getTransactionById(Long $id) : Transaction;

    /**
     * Get all transactions.
     * 
     * @return Transaction[] An arary of transactions.
     */
    public function getTransactions() : array

    /**
     * Create a new transaction
     * 
     * @param Transaction $transaction The transaction to create.
     * @return Transaction The created transaction or NULL.
     */
    public function createTransaction(Transaction $transaction) : Transaction;

    /**
     * Modify a transaction
     * 
     * @param Transaction $transaction The modified transaction.
     * @return Transaction The modified transaction or NULL.
     */
    public function updateTransaction(Transaction $transaction) : Transaction;

    /**
     * Delete a transaction
     * 
     * @param Long $id The id of the transaction to delete.
     * @return bool True on success.
     */
    public function deleteTransaction(Long $id) : bool;
}

?>