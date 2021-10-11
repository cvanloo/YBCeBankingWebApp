<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Test</title>
	</head>
	<body>
		<?php
			require_once getenv('YBC_ROOT')."/src/config/config.php";
			require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
			require_once PHP_MODULES."Repositories/Interfaces/IUserRepository.php";
			require_once PHP_MODULES."Entities/User.php";
			use Modules\Repositories\MariaDbUserRepository;
			use Modules\Entities\User;

			$repo = new MariaDbUserRepository();

			$user = User::create()->setEmail('test99@test.ch')->setUsername('test99')->setPasswdhash('apwhash99')->setAccountbalance(0);

			$created_user = $repo->createUser($user);
		?>
		<pre>
			<?php var_dump($created_user); ?>
		</pre>
		<?php ?>
	</body>
</head>
