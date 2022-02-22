<?php
// Hvis knapen submit fra login.php trykkes
if (isset($_POST["submit"])) {
    // Få uid og pwd
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    // Kræv en gang dbh-inc.php
    require_once 'dbh-inc.php';
    // Kræv en gang functions-inc.php
    require_once 'functions-inc.php';

    // Hvis login input er tomt kommer fejlen emptyinput
    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: login.php?error=emptyinput");
        exit();
    }
    // Login bruger i functions-inc.php
    loginUser($conn, $username, $pwd);
} else {
    // Ellers send brugeren tilbage til login.php
    header("location: login.php");
    exit();
}