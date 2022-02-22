<?php

session_start();

// Variabler
$id = 0;
$update = false;
$navn = '';
$lokation = '';

// Database info
$host = 'db';
$user = 'user';
$password = 'password';
$db = 'dockerdb';

// Database forbindelse
$mysqli = new mysqli($host, $user, $password, $db) or die(mysqli_error($mysqli));

// Cross-site Request Forgery
// Check hvis request er POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hvis det er POST tjek token
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        // Hvis token er ugyldig dræb siden
        die('Invalid Token');
    }
}

// Generer token
$_SESSION['_token'] = bin2hex(random_bytes(16));

// Cross Site Scripting
// Escape værdi
function escape($value) {
    // Retuner den escaped værdi, quots med UTF-8
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Post
// Hvis gem trykkes fåes navn og lokation fra form
if (isset($_POST['gem'])){
    $navn = $_POST['navn'];
    $lokation = $_POST['lokation'];
    
    
    //$mysqli->query("INSERT INTO data (navn, lokation) VALUES('$navn', '$lokation')") or die($mysqli->error);
    
    // Prepared SQL statement der indsætter navn og lokation i databasen
    $post = $mysqli->prepare("INSERT INTO data(navn, lokation) VALUES (?, ?)");
    // Placeholder ? ? værdier får navn og lokation
    $post->bind_param("ss", $navn, $lokation);

    $post->execute();

    // header sender brugeren tilbage til index.php
    header("location: index.php");
}

// Delete
// Hvis slet trykkes fåes id fra det der skal slettes
if (isset($_GET['delete'])){
    $id = $_GET['delete'];

    // Prepared SQL statement der sletter den række der skal slettes ud fra id
    $delete = $mysqli->prepare("DELETE FROM data WHERE id = ?");
    // Placeholder ? får id
    $delete->bind_param("i", $id);

    $delete->execute();

    // header sender brugeren tilbage til index.php
    header("location: index.php");
}

// Edit
// Hvis redigere trykkes fåes id fra det der skal redigeres
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    // Sætter update til true
    $update = true;
    //$result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die ($mysqli->error());

    // Prepared SQL statement til at få id fra det der skal redigeres fra databasen
    $edit = $mysqli->prepare("SELECT * FROM data WHERE id = ?");
    // Placeholder ? får id
    $edit->bind_param("i", $id);

    $edit->execute();

    // Tjekker at result findes
    if (!is_null($result)){
        // Hvis det findes få navn og lokation med fetch_array
        $row = $result->fetch_array();
        $navn = $row['navn'];
        $lokation = $row['lokation'];
    }
}

// Post update
// Hvis opdater kanppen trykkes fåes id, navn og lokation fra tekst felterne i form.php
if (isset($_POST['update'])){
    $id = $_POST['id'];
    $navn = $_POST['navn'];
    $lokation = $_POST['lokation'];

    
    //$mysqli->query("UPDATE data SET navn='$navn', lokation='$lokation' WHERE id=$id") or die($mysqli->error);

    // Prepared SQL statement til at opdater navn og lokation ud fra id
    $edit = $mysqli->prepare("UPDATE data SET navn = ?, lokation = ? WHERE id = ?");
    // Placeholder ? ? ? får navn, lokation og id
    $edit->bind_param("ssi", $navn, $lokation, $id);

    $edit->execute();

    // header sender brugeren tilbage til index.php
    header('location: index.php');
}


?>

<!--localhost<script>alert(document.cookie)</script>-->