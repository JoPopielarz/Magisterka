<?php
  if(isset($_SESSION['bladLogowania'])){
      echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['bladLogowania'];
      echo '</div><br>';
      session_unset();
  }
  if(isset($_SESSION['bladRejestracji'])){
      echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['bladRejestracji'];
      echo '</div><br>';
      session_unset();
  }
  if(isset($_SESSION['Zarejestrowano'])){
    echo '<div class="alert alert-success" role="alert">';
      echo $_SESSION['Zarejestrowano'];
    echo '</div><br>';
    session_unset();
  }
  if(isset($_SESSION['Usunieto'])){
    echo '<div class="alert alert-danger" role="alert">';
      echo $_SESSION['Usunieto'];
    echo '</div><br>';
    session_unset();
  }

  if(isset($_SESSION['zalogowany'])){
      echo '<div class="alert alert-success" role="alert">';
        echo 'Zalogowany jest: ' . $_SESSION['zalogowany'];
      echo '</div><br>';
  }

  $_SESSION['startLogowania'] = 1; //Zapisuję, że otwarto formularz logowania

  if(isset($_GET['akcja']))
    $akcja = $_GET['akcja'];
  else
    $akcja = "default";

  switch($akcja){
    default:
      ?>
      <div class="logowanie">
        <?php echo '<h4>' . $napLogowanie . '</h4><br>'; ?>
        <form action="ObslugaLogowania.php" method="post">
          <?php echo $NapNazwa; ?><br><input type="text" name="nazwa" placeholder="<?php echo $plhNazwa; ?>" required>
          <?php echo $NapHaslo; ?><br><input type="password" name="haslo" required>
          <input type="submit" value="<?php echo $btZaloguj; ?>">
        </form>
      </div>
      <br>
      <br>
      <a href="index.php?akcja=rejestracja"><h4 style="text-align: center;"><?php echo $napBrakKonta; ?></h4></a>
      <?php
      break;
    
    case 'rejestracja':
      include "forms/frmRejestracja.php";
  }
?>