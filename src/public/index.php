<?php
require_once getenv('YBC_ROOT')."/src/config/config.php";
require_once PHP_MODULES."Session.php";

require_once PHP_MODULES."Repositories/MariaDbUserRepository.php";
require_once PHP_MODULES."Repositories/MariaDbTransactionRepository.php";
require_once PHP_MODULES."DataService.php";
require_once PHP_MODULES."Entities/User.php";
require_once PHP_MODULES."Entities/Transaction.php";

use Modules\Repositories\MariaDbUserRepository;
use Modules\Repositories\MariaDbTransactionRepository;
use Modules\DataService;
use Modules\Entities\User;
use Modules\Entities\Transaction;

$GLOBALS['dataService'] = new DataService(new MariaDbUserRepository, new MariaDbTransactionRepository);

?>

<!-- TODO: Include css? -->

<!-- Include current page -->

<?php

$url = $_SERVER['REQUEST_URI'];
$baseURL = explode("?", $url)[0];

if ($baseURL === '/') {
	$baseURL = '/home';
}

$baseURL = $baseURL . '.html.php';

include_once PHP_TEMPLATES . $baseURL;

?>

<!-- TODO: Include footer -->
<footer>
    <?php include PHP_TEMPLATES . "FooterMenu.html.php";?>
</footer>