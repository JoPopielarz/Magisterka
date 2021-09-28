<?php
include "Includes/nagl.php";
if(isset($_SESSION)){
    session_destroy();
    $_SESSION = array();
}
echo "<h3>Zostałeś poprawnie wylogowany!</h3>";
echo "<h4>Zapraszamy ponownie</h4><br>";
echo '<button id="LogAg"><a href="index.php" style="color: white;">' . $btZalogujPonownie . '</a></button>';
?>