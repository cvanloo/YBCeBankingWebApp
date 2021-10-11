<?php
require_once getenv('YBC_ROOT')."/src/config/config.php";
require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
require_once PHP_MODULES."Repositories/MariaDbTransactionRepository.php";
require_once PHP_MODULES."DataService.php";

require_once PHP_MODULES."Entities/User.php";

use Modules\Repositories\MariaDbUserRepository;
use Modules\Repositories\MariaDbTransactionRepository;
use Modules\DataService;

use Modules\Entities\User;

$GLOBALS['dataService'] = new DataService(new MariaDbUserRepository, new MariaDbTransactionRepository);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Test</title>
	</head>
	<body>
		<?php
			$repo = $GLOBALS['dataService'];

			$user = User::create()->setEmail('dataservice@test.ch')->setUsername('dataservice')->setPasswdhash('dataservice')->setAccountbalance(0);

			$created_user = $repo->createUser($user);
		?>
		<pre>
			<?php var_dump($created_user); ?>
		</pre>
		<?php ?>
	</body>
</head>
