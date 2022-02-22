<?php
    include_once 'header.php';
    require_once 'process.php';
?>
<!DOCTYPE html> 
<html>
<script>
    h2 {text-align: center;}
</script>

<body>
    <!-- Opret bruger form -->
    <section class="signup-form">
        <h2 style="text-align:center">Sign up</h2>
        <div class="row justify-content-center">
            <form action="signup-inc.php" method="post">
            <!-- Session token -->
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                <div class="form-group">
                    <label>Navn</label>
                    <input type="text" name="name" class="form-control" placeholder="Navn">
                <div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Brugernavn</label>
                    <input type="text" name="uid" class="form-control" placeholder="Brugernavn">
                </div>
                <div class="form-group">
                    <label>password</label>
                    <input type="password" name="pwd" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Gentag Password</label>
                    <input type="password" name="pwdrepeat" class="form-control" placeholder="Gentag Password">
                </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary" class="form-control" name="submit">Opret</button>
                </div>
            </form>
        </div>

    <?php
    // Tjekker som der er fejl
    if (isset($_GET["error"])) {
        // Hvis fejl emptyinput så skriv Udfyld alle felter
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Udfyld alle felter</p>";
        } 
        // Hvis fejl invaliduid så skriv Vælg et ordenligt brugernavn
        else if ($_GET["error"] == "invaliduid") {
            echo "<p>Vælg et ordenligt brugernavn</p>";
        } 
        // Hvis fejl invalidemail så skriv Skriv en ordenlig email
        else if ($_GET["error"] == "invalidemail") {
            echo "<p>Skriv en ordenlig email</p>";
        } 
        // Hvis fejl passwordsdontmatch så skriv Passwords matcher ikke
        else if ($_GET["error"] == "passwordsdontmatch") {
            echo "<p>Passwords matcher ikke</p>";
        } 
        // Hvis fejl stmt failed så skriv Noget gik galt, prøv igen
        else if ($_GET["error"] == "stmtfailed") {
            echo "<p>Noget gik galt, prøv igen</p>";
        } 
        // Hvis fejl usernametaken så skriv Brugernavn allerede taget
        else if ($_GET["error"] == "usernametaken") {
            echo "<p>Brugernavn allerede taget</p>";
        }
        // Hvis fejl none så skriv Du er oprettet
        else if ($_GET["error"] == "none") {
            echo "<p>Du er oprettet</p>";
        }
    }
?>
</section>

</body>
</html>