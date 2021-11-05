<?php

// Make sure to require this on the very first line in every page of the site!
session_start();

if (!isset($_SESSION['logged_user'])) {
    $_SERVER['REQUEST_URI'] = "/Auth/Login";
}

?>