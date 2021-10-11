<?php declare(strict_types=1);

require_once getenv('YBC_ROOT')."/src/config/config.php";
require_once PHP_MODULES."Repositories/MariaDbTransactionRepository.php";
require_once PHP_MODULES."Entities/Transaction.php";
require_once PHP_MODULES."Repositories/PDOConnectionBase.php";

use PHPUnit\Framework\TestCase;
use Modules\Repositories\MariaDbTransactionRepository;
use Modules\Repositories\MariaDbUserRepository;
use Modules\Entities\Transaction;
use Modules\Entities\User;
use Modules\Repositories\PDOConnectionBase;
use Modules\Entities\TransactionState;

final class MariaDbTransactionRepositoryTest extends TestCase {
	
	use PDOConnectionBase;
	public $repo;

	// run once before class initialization
	public static function setUpBeforeClass() : void {
		global $repo;
		$repo = new MariaDbTransactionRepository();

		$command = "mysql -h localhost -u root -ptoor -e \"source " . getenv('YBC_ROOT') . "/src/mariadb.sql\"";
		print "Recreating database : $command\n";
		shell_exec($command);
	}

	// run once after class initialization
	public function setUp() : void {
		// initialize db with user entities
		$user_repo = new MariaDbUserRepository();

		$user1 = User::create()
			->setEmail('testikus@test.ch')
			->setUsername('testikus')
			->setPasswdhash('aoeuhoesuhot')
			->setAccountbalance(502.5275);

		$user2 = User::create()
			->setEmail('hii@test.ch')
			->setUsername('hii')
			->setPasswdhash('apwhash')
			->setAccountbalance(5.1238);

		$user_repo->createUser($user1);
		$user_repo->createUser($user2);
	}

	public function testCreateTransaction(): void {
		global $repo;

		$transaction = Transaction::create()
			->setAmount(50.25)
			->setTitle("Coop")
			->setObligeeId(1)
			->setDebtorId(2)
			->setStatus(TransactionState::Pending);

		$created_transaction = $repo->createTransaction($transaction);

		print "\nCreating transaction, result:\n"; var_dump($created_transaction);

		$this->assertInstanceOf(
			Transaction::class,
			$created_transaction
		);

		//$this->assertSame()
	}

	public function testGetTransactionById() {
		global $repo;

		$transaction = Transaction::create()
			->setAmount(60.22)
			->setTitle("Migros")
			->setObligeeId(2)
			->setDebtorId(1)
			->setStatus(TransactionState::Completed);

		$created_transaction = $repo->createTransaction($transaction);

		$got_transaction = $repo->getTransactionById($created_transaction->id);

		print "\nExpecting:\n"; var_dump($created_transaction);
		print "\nGot:\n";       var_dump($got_transaction);

		// NOTE(cvl): Comparing using `==` evaluates to true when the objects have the
		// same attributes and values.
		// Comparing using `===` evaluates to true if both objects refer to the same instance.
		$this->assertTrue($created_transaction == $got_transaction);
	}

	public function testGetTransactions() {
		global $repo;

		$got_transactions = $repo->getTransactions();

		print "\nGot:\n"; var_dump($got_transactions);

		$this->assertSame(2, count($got_transactions));
	}

	public function testUpdateTransaction() {
		global $repo;

		$transaction = $repo->getTransactionById(1);

		$transaction->status = TransactionState::Cancelled;

		$got_updated_transaction = $repo->updateTransaction($transaction);

		$this->assertInstanceOf(
			Transaction::class,
			$got_updated_transaction
		);
		$this->assertSame(TransactionState::Cancelled, $got_updated_transaction->status);
	}

	public function testDeleteTransactionById() {
		global $repo;

		$success = $repo->deleteTransactionById(2);

		$this->assertTrue($success);
	}
}