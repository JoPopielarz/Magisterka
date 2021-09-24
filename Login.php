<?php
    echo '<h4>' . $napLogowanie . '</h4><br>';
    if(isset($_SESSION['bladLogowania'])){
        echo '<div class="alert alert-danger" role="alert">';
          echo $_SESSION['bladLogowania'];
        echo '</div>';
        session_unset();
    }

    if(isset($_SESSION['zalogowany'])){
        echo '<div class="alert alert-success" role="alert">';
          echo 'Zalogowany jest: ' . $_SESSION['zalogowany'];
        echo '</div>';
    }

    $_SESSION['startLogowania'] = 1; //Zapisuję, że otwarto formularz logowania
?>

  <form action="ObslugaLogowania.php" method="post">
    <?php echo $NapNazwa; ?><br><input type="text" name="nazwa" placeholder="<?php echo $plhNazwa; ?>" required><br>
    <?php echo $NapMail; ?><br><input type="email" name="mail" placeholder="<?php echo $plhMail; ?>" required><br>
    <?php echo $NapHaslo; ?><br><input type="password" name="haslo" required><br>
     <br>
     <input type="submit" value="<?php echo $btZaloguj; ?>">
  </form>
  <br>
  <br>
  <h4><?php echo $napBrakKonta; ?></h4>
  <form action="Rejestracja.php" method="post">
    <?php echo $NapNazwa; ?><br><input type="text" name="nazwa" placeholder="<?php echo $plhNazwa; ?>" required><br>
    <?php echo $NapMail; ?><br><input type="email" name="mail" placeholder="<?php echo $plhMail; ?>" required><br>
    <?php echo $NapHaslo; ?><br><input type="password" name="haslo" required><br>
    <?php echo $NapHaslo2; ?><br><input type="password" name="haslo2" required><br>
    <?php echo $NapNazwisko; ?><br><input type="text" name="nazwisko" placeholder="<?php echo $plhNazwisko; ?>" required><br>
    <?php echo $NapAdres; ?><br><input type="text" name="adres" placeholder="<?php echo $plhAdres; ?>" required><br>
    <?php echo $NapMiejscowosc; ?><br><input type="text" name="miejscowosc" placeholder="<?php echo $plhMiejscowosc; ?>" required><br><br>
    <?php echo $NapRola; ?><select name="rola" placeholder="Rola użytkownika">
        <option type="hidden" value="pacjent"><?php echo $NapPacjent; ?></option>
        <option type="hidden" value="lekarz"><?php echo $NapLekarz; ?></option>
    </select><br>
    <br>
     <input type="submit" value="<?php echo $btZarejestruj; ?>">
  </form>