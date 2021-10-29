<?php

namespace config\config;

// Include paths
define("PHP_MODULES", getenv("YBC_ROOT")."/src/Modules/");
define("PHP_TEMPLATES", getenv("YBC_ROOT")."/src/Templates/");

// Database
define("DB_PROVIDER", "mariadb");
define("DB_CONNECTION", "mysql:host=localhost;dbname=YBCBanking");
define("DB_USER", "root");   // The database user name
define("DB_PASSWD", "toor"); // The database user password

?>
