<?php declare(strict_types=1);

require_once getenv('YBC_ROOT')."/src/config/config.php";

require_once PHP_MODULES."DataService.php";
require_once PHP_MODULES."IDataService.php";

require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
require_once PHP_MODULES."Repositories/MariaDbTransactionRepository.php";

require_once PHP_MODULES."Entities/User.php";

use PHPUnit\Framework\TestCase;

use Modules\DataService;
use Modules\IDataService;

use Modules\Repositories\MariaDbTransactionRepository;
use Modules\Repositories\MariaDbUserRepository;

use Modules\Entities\User;
use Modules\Entities\Transaction;
use Modules\Entities\TransactionState;

final class DataServiceTransactionTest extends TestCase {
	
	protected IDataService $repo;
	private int $obligee_id;
	private int $debtor_id;

	// run once before class initialization
	public static function setUpBeforeClass() : void {
		global $repo;
		$repo = new DataService(new MariaDbUserRepository(), new MariaDbTransactionRepository());
	}

	// run once after class initialization
	public function setUp() : void {
		global $repo;
		global $obligee_id;
		global $debtor_id;

		$ticks = microtime();

		// setup test users
		$u1 = User::create()                     // id, created, deleted AUTO
			->setEmail("test_ob{$ticks}@email.com") // UNIQUE
			->setUsername("test_ob{$ticks}")        // UNIQUE
			->setPasswdhash('apwhash')
			->setAccountbalance(25.5);

		$u2 = User::create()                     // id, created, deleted AUTO
			->setEmail("test_deb{$ticks}@email.com") // UNIQUE
			->setUsername("test_deb{$ticks}")        // UNIQUE
			->setPasswdhash('apwhash')
			->setAccountbalance(25.5);

		$obligee_id = $repo->createUser($u1)->id;
		$debtor_id = $repo->createUser($u2)->id;
	}
	
	private function propertiesAreEqual($expected, $actual) : void {
		// asserts transaction is non-null
		$this->assertInstanceOf(
			Transaction::class,
			$expected
		);

		$this->assertInstanceOf(
			Transaction::class,
			$actual
		);

		$this->assertSame($expected->amount, $actual->amount);
		$this->assertSame($expected->title, $actual->title);
		$this->assertSame($expected->description, $actual->description);
		$this->assertSame($expected->obligee_id, $actual->obligee_id);
		$this->assertSame($expected->debtor_id, $actual->debtor_id);
		$this->assertsame($expected->status, $actual->status);
	}

	public function testCreateAndRead() : void {
		global $repo;
		global $obligee_id;
		global $debtor_id;

		$ticks = microtime();

		$row = Transaction::create() // id, created AUTO
			->setAmount(120.526)
			->setTitle('Test Transaction')
			->setDescription('Test Description')
			->setObligeeId($obligee_id)
			->setDebtorId($debtor_id)
			->setStatus(TransactionState::Pending);

		$echo = $repo->createTransaction($row);

		$this->propertiesAreEqual($row, $echo);
	}

	public function testCreateAndUpdate() : void {
		global $repo;
		global $obligee_id;
		global $debtor_id;

		$ticks = microtime();

		$v1 = Transaction::create() // id, created AUTO
			->setAmount(120.526)
			->setTitle('Test Transaction')
			->setDescription('Test Description')
			->setObligeeId($obligee_id)
			->setDebtorId($debtor_id)
			->setStatus(TransactionState::Pending);

		$v2 = $repo->createTransaction($v1);

		$this->propertiesAreEqual($v1, $v2);

		$v2->title = "Modified Transaction";

		$v3 = $repo->updateTransaction($v2);

		$this->propertiesAreEqual($v2, $v3);
	}

	public function testCreateAndDelete() : void {
		global $repo;
		global $obligee_id;
		global $debtor_id;

		$ticks = microtime();

		$v1 = Transaction::create() // id, created AUTO
			->setAmount(120.526)
			->setTitle('Test Transaction')
			->setDescription('Test Description')
			->setObligeeId($obligee_id)
			->setDebtorId($debtor_id)
			->setStatus(TransactionState::Pending);

		$v2 = $repo->createTransaction($v1);
		$this->propertiesAreEqual($v1, $v2);

		$success = $repo->deleteTransactionById($v2->id);
		$this->assertTrue($success);

		$v3 = $repo->getTransactionById($v2->id);
		$this->assertNull($v3);

		// TODO: Soft deletes
	}

	public function testFilteredRead() : void {
		global $repo;
		global $obligee_id;
		global $debtor_id;

		$matching_source = array();

		for ($i = 0; $i < 10; $i++) {
			$ticks = microtime();
			$matching_source[] = Transaction::create()    // id, created AUTO
				->setAmount(140)                          // expected change
				->setTitle('Test Transaction')
				->setDescription('Test Description')
				->setObligeeId($obligee_id)               // expected change
				->setDebtorId($debtor_id)                 // expected change
				->setStatus(TransactionState::Completed); // expected change
		}

		$non_matching_source = array();

		for ($i = 0; $i < 10; $i++) {
			$ticks = microtime();
			$non_matching_source[] = Transaction::create() // id, created AUTO
				->setAmount(120.526)
				->setTitle("Test Transaction_{$ticks}")
				->setDescription('Test Description')
				->setObligeeId($debtor_id)
				->setDebtorId($obligee_id)
				->setStatus(TransactionState::Pending);
		}

		foreach ($matching_source as $m_source) {
			$repo->createTransaction($m_source);
		}
		foreach ($non_matching_source as $nm_source) {
			$repo->createTransaction($nm_source);
		}

		$results = $repo->findTransactionsWithFilter([
			'amount'     => 140.0,
			'obligee_id' => $obligee_id,
			'debtor_id'  => $debtor_id,
			'status'     => TransactionState::Completed
		]);

		foreach ($matching_source as $expected) {
			$got = null;

			foreach ($results as $result) {
				// NOTE(cvl): id not initialized yet, title is not explicitly
				// set to unique, but we made sure to use only unique titles.
				if ($expected->title === $result->title) {
					$got = $result;
					break;
				}
			}

			$this->assertNotNull($got);
		}

		$non_matching_results = array();

		foreach ($results as $result) {
			if (
				$result->amount !== 140.0 ||
				$result->obligee_id !== $obligee_id ||
				$result->debtor_id !== $debtor_id ||
				$result->status !== TransactionState::Completed
			) {
				$non_matching_results[] = $result;
			}
		}

		$this->assertTrue(count($non_matching_results) === 0);
	}
}