<?php

namespace Modules;

require_once PHP_MODULES."Repositories/Interfaces/IUserRepository.php";
require_once PHP_MODULES."Repositories/Interfaces/ITransactionRepository.php";
require_once PHP_MODULES."IDataService.php";
require_once PHP_MODULES."Entities/User.php";
require_once PHP_MODULES."Entities/Transaction.php";

use Modules\Repositories\Interfaces\IUserRepository;
use Modules\Repositories\Interfaces\ITransactionRepository;
use Modules\Entities\User;
use Modules\Entities\Transaction;

/**
 * Wrapper around the repository interface to make replacing the
 * data providers easier.
 */
class DataService implements IDataService {

	private IUserRepository $_userRepository;
	private ITransactionRepository $_transactionRepository;

	public function __construct(IUserRepository $userRepository, ITransactionRepository $transactionRepository) {
		$this->_userRepository = $userRepository;
		$this->_transactionRepository = $transactionRepository;
	}

    public function getUserById(int $id) : ?User {
		return $this->_userRepository->getUserById($id);
	}

    public function getUsers() : array {
		return $this->_userRepository->getUsers();
	}

	public function findUsersWithFilter(array $filter_list) : array {
		return $this->_userRepository->findUsersWithFilter($filter_list);
	}

    public function createUser(User $user) : ?User {
		return $this->_userRepository->createUser($user);
	}

    public function updateUser(User $user) : ?User {
		return $this->_userRepository->updateUser($user);
	}

    public function deleteUserById(int $id) : bool {
		return $this->_userRepository->deleteUserById($id);
	}

    public function getTransactionById(int $id) : ?Transaction {
		return $this->_transactionRepository->getTransactionById($id);
	}

    public function getTransactions() : array {
		return $this->_transactionRepository->getTransactions();
	}

	public function findTransactionsWithFilter(array $filter_list) : array {
		return $this->_transactionRepository->findTransactionsWithFilter($filter_list);
	}

    public function createTransaction(Transaction $transaction) : ?Transaction {
		return $this->_transactionRepository->createTransaction($transaction);
	}

    public function updateTransaction(Transaction $transaction) : ?Transaction {
		return $this->_transactionRepository->updateTransaction($transaction);
	}

    public function deleteTransactionById(int $id) : bool {
		return $this->_transactionRepository->deleteTransactionById($id);
	}
}

?>