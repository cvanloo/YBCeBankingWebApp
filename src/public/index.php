<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Test</title>
	</head>
	<body>
		<?php
			require_once "/home/miya/Edu/01_TBZ/Informatikmodule/M306/04_Projekt/YBCeBankingWebApp/src/config/config.php";
			require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
			require_once PHP_MODULES."Repositories/Interfaces/IUserRepository.php";
			require_once PHP_MODULES."Entities/User.php";
			use Modules\Repositories\MariaDbUserRepository;
			use Modules\Entities\User;

			$repo = new MariaDbUserRepository();

			$user = User::create()->setEmail('test10@test.ch')->setUsername('test10')->setPasswdhash('apwhash10')->setAccountbalance(0);

			$created_user = $repo->createUser($user);
			var_dump($created_user);
		?>
	</body>
</head>
