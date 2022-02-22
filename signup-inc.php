<?php
// Checker om brugeren klikker submit og ikke kommer ind i filen ved at skrive URL
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    // kræv en gang db-inc.php
    require_once 'dbh-inc.php';
    // kræv en gang functions-inc.php
    require_once 'functions-inc.php';

    // Checker om signup input er tomt i functions-inc.php
    if (emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat) !== false) {
        header("location: signup.php?error=emptyinput");
        exit();
    }
    // Checker om brugernavn er ugylidgt i functions-inc.php
    if (invalidUid($username) !== false) {
        header("location: signup.php?error=invaliduid");
        exit();
    }
    // Checker om email er ugyldig i functions-inc.php
    if (invalidEmail($email) !== false) {
        header("location: signup.php?error=invalidemail");
        exit();
    }
    // Checker om passwords matcher i functions-inc.php
    if (pwdmatch($pwd, $pwdrepeat) !== false) {
        header("location: signup.php?error=Passworddontmatch");
        exit();
    }
    // Checker om brugernavn og email allerede findes i functions-inc.php
    if (uidExists($conn, $username, $email) !== false) {
        header("location: signup.php?error=usernametaken");
        exit();
    }
    // Opretter ny bruger i functions-inc.php
    createUser($conn, $name, $email, $username, $pwd);

} else {
    // Hvis brugeren prøver at tilgå denne fil bliver de sendt tilbage til signup.php
    header("location: signup.php");
}