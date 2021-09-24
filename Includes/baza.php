<?php
function polaczenie(){
    global $txtBladPolaczenia;
    $serwerDB = "mysql.agh.edu.pl";
    $login = "popiela1";
    $haslo = "Magisterka2021";
    $baza = "popiela1";

    if(isset($_SESSION['bladPolaczenia'])) unset($_SESSION['bladPolaczenia']);
    $polaczenie = @new mysqli($serwerDB, $login, $haslo, $baza);

    if($polaczenie->connect_errno != 0){
        $_SESSION['bladPolaczenia'] = $txtBladPolaczenia . $polaczenie->connect_error();
        return NULL;
    }
    else{
        $polaczenie->set_charset("utf8");
        return $polaczenie;
    }
}

function zapytanieDoBazy($polaczenie, $zapytanie){
    if($rezultat = $polaczenie->query($zapytanie))
        return $rezultat;
    else
        return NULL;
}

?>