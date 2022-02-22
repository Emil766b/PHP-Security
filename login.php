<?php
    include_once 'header.php';
    require_once 'process.php';
?>
<!-- Login form -->
<section class="login-form">
    <h2 style="text-align:center">Login</h2>
    <div class="row justify-content-center">
        <form action="login-inc.php" method="post">
            <!-- Session token -->
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
            <div class="form-group">
                <label>Brugernavn eller Email</label>
                <input type="text" name="uid" class="form-control" placeholder="Brugernavn/Email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pwd" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit">Login</button>
            </div>
        </form>
    </div>
    <?php
    // Tjekker som der er fejl
    if (isset($_GET["error"])) {
        // Hvis fejl emptyinput så skriv udfyld alle felter
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Udfyld alle felter</p>";
        } 
        // Hvis fejl wronglogin så skriv forkert login
        else if ($_GET["error"] == "wronglogin") {
            echo "<p>Forkert login</p>";
        } 
    }
?>
</section>


