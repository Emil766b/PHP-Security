<?php
    // Inkluder header.php
    include_once 'header.php';
?>

<?php
    // Hvis en bruger er logget ind og derfor er en session igang inkludere form.php
    if (isset($_SESSION["useruid"])) {
        include_once 'form.php';
    } else {
        // ellers inkludere login.php
        include_once 'login.php';
    }
?>