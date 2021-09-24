<?php
session_start();
include "Includes/nagl.php";
include "Includes/baza.php";
include "Includes/zapytania.php";

if(($mojePolaczenie = polaczenie()) == NULL){
    echo $_SESSION['bladPolaczenia'];
}

if(isset($_POST['nazwa'])){
    $Lnazw = mysqli_query($mojePolaczenie, sprintf($RejestracjaSprawdzanie, $_POST['nazwa']));
    $liczbaNazw = mysqli_fetch_array($Lnazw)[0];
    if($liczbaNazw != 0){
        echo "<h4 style=\"text-align: center\"><br>Wybrana nazwa użytkownika jest już zajęta! Proszę wybrać inną</h4><br>";
        echo '<button style="margin-left: 50%"><a href="index.php">' . $btPowrot . '</a></button>';
    }elseif($_POST['haslo'] != $_POST['haslo2']){
        echo "<h4 style=\"text-align: center\"><br>Podane hasła się różnią! Proszę zarejestrować się od nowa:</h4><br>";
        echo '<button style="margin-left: 50%"><a href="index.php">' . $btPowrot . '</a></button>';
    }else{
        $szablon = $mojePolaczenie->prepare($Rejestracja);
        $szablon->bind_param("sssssss", $arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7);
        $arg1 = $_POST['nazwa'];
        $arg2 = $_POST['mail'];
        $arg3 = $_POST['haslo'];
        $arg4 = $_POST['rola'];
        $arg5 = $_POST['nazwisko'];
        $arg6 = $_POST['adres'];
        $arg7 = $_POST['miejscowosc'];
        $szablon->execute();
        echo "<h4><br>Dodano użytkownika: " . $_POST['nazwa'] . "<br>Mail: " . $_POST['mail'] . "</h4><br>";
        $szablon->close();
        echo '<button><a href="index.php">' . $btPowrot . '</a></button>';
    }
}

include "Includes/stopka.php";
?>