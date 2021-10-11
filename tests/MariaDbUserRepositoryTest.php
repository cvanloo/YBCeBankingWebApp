<?php declare(strict_types=1);

require_once getenv('YBC_ROOT')."/src/config/config.php";
require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
require_once PHP_MODULES."Entities/User.php";
require_once PHP_MODULES."Repositories/PDOConnectionBase.php";

use PHPUnit\Framework\TestCase;
use Modules\Repositories\MariaDbUserRepository;
use Modules\Entities\User;
use Modules\Repositories\PDOConnectionBase;

final class MariaDbUserRepositoryTest extends TestCase {
	
	use PDOConnectionBase;

	public $repo;

	// run once before class initialization
	public static function setUpBeforeClass() : void {
		global $repo;
		$repo = new MariaDbUserRepository();

		$command = "mysql -h localhost -u root -ptoor -e \"source " . getenv('YBC_ROOT') . "/src/mariadb.sql\"";
		print "Recreating database : $command\n";
		shell_exec($command);
	}

	// run once after class initialization
	public function setUp() : void { }

	public function testCreateUser(): void {
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

	public function testGetUserById() {
		global $repo;

		$user = User::create()->setEmail('testikus@test.ch')->setUsername('testikus')->setPasswdhash('aoeuhoesuhot')->setAccountbalance(502.5275);
		$created_user = $repo->createUser($user);

		$got_user = $repo->getUserById($created_user->id);

		print "\nExpecting:\n"; var_dump($created_user);
		print "\nGot:\n";       var_dump($got_user);

		// NOTE(cvl): Comparing using `==` evaluates to true when the objects have the
		// same attributes and values.
		// Comparing using `===` evaluates to true if both objects refer to the same instance.
		$this->assertTrue($created_user == $got_user);
	}

	public function testGetUsers() {
		global $repo;

		$got_users = $repo->getUsers();

		print "\nGot:\n"; var_dump($got_users);

		$this->assertSame(2, count($got_users));
	}

	public function testUpdateUser() {
		global $repo;

		$user = $repo->getUserById(1);

		$user->accountbalance = 1200.8;

		$got_updated_user = $repo->updateUser($user);

		$this->assertInstanceOf(
			User::class,
			$got_updated_user
		);
		$this->assertSame(1200.8, $got_updated_user->accountbalance);
	}

	public function testDeleteUserById() {
		global $repo;

		$success = $repo->deleteUserById(2);

		$this->assertTrue($success);
	}
}