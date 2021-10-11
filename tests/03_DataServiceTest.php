<?php declare(strict_types=1);

require_once getenv('YBC_ROOT')."/src/config/config.php";

require_once PHP_MODULES."DataService.php";

require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
require_once PHP_MODULES."Repositories/MariaDbTransactionRepository.php";

require_once PHP_MODULES."Entities/User.php";

use PHPUnit\Framework\TestCase;

use Modules\DataService;

use Modules\Repositories\MariaDbTransactionRepository;
use Modules\Repositories\MariaDbUserRepository;

use Modules\Entities\User;

final class DataServiceTest extends TestCase {
	
	protected $repo;

	// run once before class initialization
	public static function setUpBeforeClass() : void {
		global $repo;
		$repo = new DataService(new MariaDbUserRepository(), new MariaDbTransactionRepository());

		$command = "mysql -h localhost -u root -ptoor -e \"source " . getenv('YBC_ROOT') . "/src/mariadb.sql\"";
		print "Recreating database : $command\n";
		shell_exec($command);
	}

	// run once after class initialization
	public function setUp() : void {
	
	}

	public function testGetUserById() {
		global $repo;

		$user = User::create()->setEmail('hii@test.ch')->setUsername('hii')->setPasswdhash('apwhash')->setAccountbalance(5.1238);

		$created_user = $repo->createUser($user);

		print "\nCreating user, result:\n"; var_dump($created_user);

		$this->assertInstanceOf(
			User::class,
			$created_user
		);

		$this->assertSame(1, $created_user->id);
		$this->assertSame('hii@test.ch', $created_user->email);
		$this->assertSame('hii', $created_user->username);
		$this->assertSame('apwhash', $created_user->passwdhash);
		$this->assertSame(5.1238, $created_user->accountbalance);
		$this->assertTrue(($created_user->created != null && $created_user->created != ""));
		$this->assertSame(false, $created_user->deleted);
		// TODO: Transaction?
	}
}