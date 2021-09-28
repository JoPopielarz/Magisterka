<?php
session_start();
include "Includes/nagl.php";
include "Includes/baza.php";
include "Includes/zapytania.php";

if(($mojePolaczenie = polaczenie()) == NULL){
    echo $_SESSION['bladPolaczenia'];
}

if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($Logowanie, $_POST['nazwa']))){
    $wiersz = $wynik->fetch_assoc();
    if($_POST['nazwa'] == $wiersz['NazwaUzytkownika']){
        if(password_verify($_POST['haslo'], $wiersz['Haslo'])){
            echo "Logowanie poprawne";
            $_SESSION['zalogowany'] = $wiersz['NazwaUzytkownika'];
            $_SESSION['iduzytkownika'] = $wiersz['iduzytkownika'];
            $_SESSION['rola'] = $wiersz['Rola'];
            header("Location: index.php");
        }else{
            $_SESSION['bladLogowania'] = "Błędnie wprowadzone hasło - spróbuj jeszcze raz";
            header("Location: index.php");
        }
    }else{
        $_SESSION['bladLogowania'] = "Błędnie wprowadzony login - spróbuj jeszcze raz";
        header("Location: index.php");
    }
}

include "Includes/stopka.php";
?>