<?php
include "Includes/nagl.php";
if(isset($_SESSION)){
    session_destroy();
    $_SESSION = array();
}
echo "<h3>Zostałeś poprawnie wylogowany!</h3>";
echo "<h4>Zapraszamy ponownie</h4><br>";
echo '<button><a href="index.php">' . $btZalogujPonownie . '</a></button>';
?>