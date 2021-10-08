<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Test</title>
	</head>
	<body>
		<?php
			require_once "/home/miya/code/PHP/YBCeBankingWebApp/src/config/config.php";
			require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
			require_once PHP_MODULES."Repositories/Interfaces/IUserRepository.php";
			use Modules\Repositories\MariaDbUserRepository;

			$repo = new MariaDbUserRepository();
			$repo->getUserById(0);
		?>
	</body>
</head>
