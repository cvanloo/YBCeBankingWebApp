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

final class DataServiceUserTest extends TestCase {
	
	protected IDataService $repo;

	// run once before class initialization
	public static function setUpBeforeClass() : void {
		global $repo;
		$repo = new DataService(new MariaDbUserRepository(), new MariaDbTransactionRepository());

		//$command = "mysql -h localhost -u root -ptoor -e \"source " . getenv('YBC_ROOT') . "/src/mariadb.sql\"";
		//print "Recreating database : $command\n";
		//shell_exec($command);
	}

	// run once after class initialization
	public function setUp() : void {
	
	}
	
	private function propertiesAreEqual($expected, $actual) : void {
		// asserts user is non-null
		$this->assertInstanceOf(
			User::class,
			$expected
		);

		$this->assertInstanceOf(
			User::class,
			$actual
		);

		$this->assertSame($expected->email, $actual->email);
		$this->assertSame($expected->username, $actual->username);
		$this->assertSame($expected->passwdhash, $actual->passwdhash);
		$this->assertSame($expected->accountbalance, $actual->accountbalance);
		// TODO: Transactions
	}

	public function testCreateAndRead() : void {
		global $repo;

		$ticks = microtime();

		$row = User::create()                    // id, created, deleted AUTO
			->setEmail("test{$ticks}@email.com") // UNIQUE
			->setUsername("test{$ticks}")        // UNIQUE
			->setPasswdhash('apwhash')
			->setAccountbalance(5.1238);
			// TODO: Transactions

		$echo = $repo->createUser($row);

		$this->propertiesAreEqual($row, $echo);
	}

	public function testCreateAndUpdate() : void {
		global $repo;

		$ticks = microtime();

		$v1 = User::create()
			->setEmail("test{$ticks}@email.com")
			->setUsername("test{$ticks}")
			->setPasswdHash('apwhash')
			->setAccountBalance(5.1238);
			// TODO: Transactions

		$v2 = $repo->createUser($v1);

		$this->propertiesAreEqual($v1, $v2);

		$v2->username = "modified{$ticks}@email.com";

		$v3 = $repo->updateUser($v2);

		$this->propertiesAreEqual($v2, $v3);
	}

	public function testCreateAndDelete() : void {
		global $repo;

		$ticks = microtime();

		$v1 = User::create()
			->setEmail("test{$ticks}@email.com")
			->setUsername("test{$ticks}")
			->setPasswdHash('apwhash')
			->setAccountBalance(5.1238);
			// TODO: Transactions

		$v2 = $repo->createUser($v1);
		$this->propertiesAreEqual($v1, $v2);

		$success = $repo->deleteUserById($v2->id);
		$this->assertTrue($success);

		$v3 = $repo->getUserById($v2->id);
		$this->assertNull($v3);

		// TODO: Soft deletes
	}

	public function testFilteredRead() : void {
		global $repo;

		// create source elements for successful test
		$matching_source = array();

		for ($i = 0; $i < 10; $i++) {
				$ticks = microtime();
				$matching_source[] = User::create()
					->setEmail("test{$ticks}_A{$i}@email.com")
					->setUsername("test{$ticks}_A{$i}")
					->setPasswdHash('apwhash')
					->setAccountBalance(55.784);
					// TODO: Transactions
		}

		// create source elements for failed test
		$non_matching_source = array();

		for ($i = 0; $i < 10; $i++) {
			$ticks = microtime();
			$non_matching_source[] = User::create()
				->setEmail("test{$ticks}_B{$i}@email.com")
				->setUsername("test{$ticks}_B{$i}")
				->setPasswdHash('apwhash')
				->setAccountBalance(77);
		}

		foreach ($matching_source as $m_source) {
			$repo->createUser($m_source);
		}
		foreach ($non_matching_source as $nm_source) {
			$repo->createUser($nm_source);
		}

		// get users with an accountbalance of 55.784
		$results = $repo->findUsersWithFilter(['accountbalance' => 55.784]);

		// check results for expected elements
		foreach ($matching_source as $expected) {
			$got = null;

			foreach ($results as $result) {
				// NOTE(cvl): id not initialized yet.
				if ($expected->username === $result->username) {
					$got = $result;
					break;
				}
			}

			$this->assertNotNull($got);
		}

		// check results for unexpected elements
		$non_matching_results = array();

		foreach ($results as $result) {
			if ($result->accountbalance !== 55.784) {
				$non_matching_results[] = $result;
			}
		}

		$this->assertTrue(count($non_matching_results) === 0);
	}
}