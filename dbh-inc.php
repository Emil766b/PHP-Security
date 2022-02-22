<?php
// Database info
$host = 'db';
$user = 'user';
$password = 'password';
$db = 'dockerdb';

// Database forbindelse
$conn = mysqli_connect($host, $user, $password, $db);

// Hvis forbindelsen fejler afslut og kom med fejl
if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}