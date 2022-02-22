<!DOCTYPE html> 
<html>
    <head>
        <meta charset="UTF-8">
        <title>PHP Security</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Inkluder process.php.php -->
        <?php require 'process.php'; ?>
        
        <div class="container">
        <?php
            // Database login info
            $host = 'db';
            $user = 'user';
            $password = 'password';
            $db = 'dockerdb';
            // Forbindelse til SQL med mysqli
            $mysqli = new mysqli($host, $user, $password, $db) or die(mysqli_error($mysqli));
            // result vælger alt fra data tabellen
            $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
            ?>

            <!-- tabel der viser data fra tabellen data -->
            <div class="row justify-content-center">
                <!-- Tabel -->
                <table class="table">
                    <!-- Tabel head -->
                    <thead>
                        <!-- Tabel row -->
                        <tr>
                            <th>Navn</th>
                            <th>Lokation</th>
                            <th colspan="2">Handling</th>
                        </tr>
                    </thead>
                <?php
                    // Loop igennem result med fetch_assoc som får alt data fra databasen
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <!-- Vis navn og lokation fra databasen -->
                            <td><?php echo escape($row['navn']); ?></td>
                            <td><?php echo escape($row['lokation']); ?></td>
                            <td>
                                <!-- Rediger knap der opretter edit variabel med id af det der skal redigeres -->
                                <a href="index.php?edit=<?php echo $row['id'] ?>"
                                    class="btn btn-info">Rediger</a>
                                <!-- Slet knap kan der opretter delete variabel med id af det der skal slettes -->
                                <a href="process.php?delete=<?php echo $row['id']; ?>" 
                                    class="btn btn-danger">Slet</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table> 
            </div>

        <!-- Tilføj data form -->
        <div class="container-fluid">
        <!-- Inline form der bruger process.php og metode post -->
        <form class="form-inline justify-content-center" action="process.php" method="POST">
            <!-- Skjult input der indeholder id der skal bruges i post til at opdatere det der skal opdateres -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <!-- Session token -->
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                <!-- Navn input -->
                <label class="m-2">Navn</label>
                <!-- Input til navn som også kan bruges til at redigere navn, data for at redigere kommer fra edit i process.php -->
                <input type="text" name="navn" class="form-control" value="<?php echo $navn; ?>" placeholder="Indset navn">
                <!-- Lokation input -->
                <label class="m-2">Lokation</label>
                <!-- Input til lokation som også kan bruges til at redigere lokation, data for at redigere kommer fra edit i process.php -->
                <input type="text" name="lokation" class="form-control" value="<?php echo $lokation; ?>" placeholder="indset lokation">
                <div class="form-check m-2">
                </div>
                <!-- Gem/Opdater knap -->
                <?php
                // Hvis redigere knappen trykkes og derfor er true i process.php
                if ($update == true):
                ?>
                    <!-- Så brug opdater knappen -->
                    <button type="submit" class="btn btn-warning" name="update">Opdater</button>
                <?php else: ?>
                    <!-- Ellers brug gem knappen -->
                    <button type="submit" class="btn btn-primary" name="gem">Gem</button>
                <?php endif; ?>
            </form>
        </div>
    </body>
</html>
