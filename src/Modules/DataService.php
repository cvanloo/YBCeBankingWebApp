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

class DataService implements IDataService {
	private IUserRepository $_userRepository;
	private ITransactionRepository $_transactionRepository;

	public function __construct(IUserRepository $userRepository, ITransactionRepository $transactionRepository) {
		$this->_userRepository = $userRepository;
		$this->_transactionRepository = $transactionRepository;
	}

    public function getUserById(int $id) : User {
		return $this->_userRepository->getUserById($id);
	}

    public function getUsers() : array {
		return $this->_userRepository->getUsers();
	}

    public function createUser(User $user) : User {
		return $this->_userRepository->createUser($user);
	}

    public function updateUser(User $user) : User {
		return $this->_userRepository->updateUser($user);
	}

    public function deleteUser(Long $id) : bool {
		return $this->_userRepository->deleteUser($id);
	}

    public function getTransactionById(Long $id) : Transaction {
		return $this->_transactionRepository->getTransactionById($id);
	}

    public function getTransactions() : array {
		return $this->_transactionRepository->getTransactions();
	}

    public function createTransaction(Transaction $transaction) : Transaction {
		return $this->_transactionRepository->createTransaction($transaction);
	}

    public function updateTransaction(Transaction $transaction) : Transaction {
		return $this->_transactionRepository->updateTransaction($transaction);
	}

    public function deleteTransaction(Long $id) : bool {
		return $this->_transactionRepository->deleteTransaction($transaction);
	}
}

?>