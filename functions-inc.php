<?php
// Funktion der tjekker om signup er tomt
function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat) {
    $result;
    // Hvis noget er tomt bliver result true og giver fejl
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)) {
    $result = true;
} else {
    // Ellers er result false og fortsætter
    $result = false;
    }
    // Retunere result
    return $result;
}
// Funktion der tjekker om brugernavnet er gyldigt
function invalidUid($username) {
    $result;
    // Hvis brugernavnet ikke matcher søge algoritmen så true
    // Søge algoritmen tjekker om brugernavet indeholder fra a til z med små og store bogstaver og tal fra 0 til 9
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = true;
} else {
    // Ellers er result false og fortsætter
    $result = false;
    }
    // Retunere result
    return $result;
}
// Funktion der tjekker om det er en valid email
function invalidEmail($email) {
    $result;
    // Hvis email ikke er valideret af filteret så true
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
} else {
    // Ellers er result false og fortsætter
    $result = false;
    }
    // Retunere result
    return $result;
}
// Funktion der tjekker om password og passwordrepeat matcher
function pwdMatch($pwd, $pwdrepeat) {
    $result;
    // Hvis password og passwordrepeat ikke mathcer er det true
    if ($pwd !== $pwdrepeat) {
    $result = true;
} else {
    // Ellers er result false og fortsætter
    $result = false;
    }
    // Retunere result
    return $result;
}
// Funktion der tjekker om brugernavn og email allerede er taget
function uidExists($conn, $username, $email) {
    // SQL query hvor kun brugernavn og email kan indsættes
    $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ?;";
    // Prepared SQL statement init med database forbindelse
    $stmt = mysqli_stmt_init($conn);
    // Prepared SQL statement hvis noget går galt kommer den med fejlen stmtfailed
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: signup.php?error=stmtfailed");
        exit();
    }
    // Bind Prepared SQL statement med typen string string til det indtastet brugernavn og email
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    // Kører prepared SQL statement
    mysqli_stmt_execute($stmt);
    // Få resultat fra prepared SQL statement
    $resultData = mysqli_stmt_get_result($stmt);
    // Hvis resultData finder noget findes brugernavnet og eller email allerede og er true
    // Opretter samtidig variable row til login
    if ($row = mysqli_fetch_assoc($resultData)) {
        // Retunere row
        return $row;
    } else {
        // Ellers er result false
        $result = false;
        // Retunere result
        return $result;
    }
    // Lukker prepared SQL statement
    mysqli_stmt_close($stmt);
}
// Funktion der opretter ny bruger
function createUser($conn, $name, $email, $username, $pwd) {
    // SQL query hvor navn, email, brugernavn og password kan indsættes
    $sql = "INSERT INTO users (userName, UserEmail, userUid, userPwd) VALUES (?, ?, ?, ?);";
    // Prepared SQL statement init med database forbindelse
    $stmt = mysqli_stmt_init($conn);
    // Prepared SQL statement hvis noget går galt kommer den med fejlen stmtfailed
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: signup.php?error=stmtfailed");
        exit();
    }
    
    // Laver et hashed password af det passord der er indtastet
    $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
    // Bind Prepared SQL statement med typen string string string string til det indtastet navn, email, brugernavn og hashedpassword
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $username, $hashedpwd);
    // Kører prepared SQL statement
    mysqli_stmt_execute($stmt);
    // Lukker prepared SQL statement
    mysqli_stmt_close($stmt);
    // Sender brugeren til signup.php
    header("location: signup.php?error=none");
    exit();
}
// Funktion der tjekker om login input er tomt
function emptyInputLogin($username, $pwd) {
    $result;
    // Hvis brugernavn eller passowrd er tomt er det true
    if (empty($username) || empty($pwd)) {
    $result = true;
} else {
    // Ellers er result false
    $result = false;
    }
    // Retunere result
    return $result;
}
// Funktion der logger brugeren ind
function loginUser($conn, $username, $pwd) {
    // Checker om brugeren findes i databasen
    // username 1 = username, username 2 = email
    $uidExists = uidExists($conn, $username, $username);

    // Hvis brugernavn ikke findes send brugeren til login.php med fejl wronglogin
    if ($uidExists === false) {
        header("location: login.php?error=wronglogin");
        exit();
    }

    // Få password fra associative array
    $pwdHashed = $uidExists["userPwd"];

    // Verificer at det indtastet password matcher password fra databasen
    $checkPwd = password_verify($pwd, $pwdHashed);

    // Hvis passwords ikke matcher send brugeren til login.php med fejl wronglogin
    if ($checkPwd === false) {
        header("location: login.php?error=wronglogin");
        exit();
        // Ellers log brugeren ind 
    } else if ($checkPwd === true) {
        // Start session
        session_start();
        // Session med navn userid og indeholder userid
        $_SESSION["userid"] = $uidExists["userId"];
        // Session med navn brugernavn og indeholder brugernavn
        $_SESSION["useruid"] = $uidExists["userUid"];
        // Send bruger til index.php
        header("location: index.php");
        exit();
    }
}
