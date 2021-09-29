<?php
session_start();
include "Includes/nagl.php";
include "Includes/baza.php";
include "Includes/zapytania.php";

if(($mojePolaczenie = polaczenie()) == NULL){
    echo $_SESSION['bladPolaczenia'];
}

if(isset($_POST['nazwa'])){
    //Flaga udanej walidacji konta
    $walidacja = true;
    //Sprawdzenie loginu
    $Lnazw = mysqli_query($mojePolaczenie, sprintf($RejestracjaSprawdzanie, $_POST['nazwa']));
    $liczbaNazw = mysqli_fetch_array($Lnazw)[0];
    if($liczbaNazw != 0){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Wybrana nazwa użytkownika jest już zajęta! Proszę wybrać inną";
        header("Location: index.php?akcja=rejestracja");
    }
    if((strlen($_POST['nazwa'])<3) || (strlen($_POST['nazwa'])>20)){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Nazwa użytkownika musi posiadać od 3 do 20 znaków!";
        header("Location: index.php?akcja=rejestracja");
    }
    if(ctype_alnum($_POST['nazwa']) == false){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Nazwa użytkownika może składać się tylko z liter i cyfr (bez polskich znaków)";
        header("Location: index.php?akcja=rejestracja");
    }
    //Sprawdzanie adresu e-mail
    $emailSafe = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    if((filter_var($emailSafe, FILTER_VALIDATE_EMAIL)==false) || ($emailSafe!=$_POST['mail'])){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Podaj poprawny adres e-mail!";
        header("Location: index.php?akcja=rejestracja");
    }
    //Sprawdzenie hasła
    if((strlen($_POST['haslo'])<8) || (strlen($_POST['haslo'])>20)){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Hasło musi posiadać od 8 do 20 znaków!";
        header("Location: index.php?akcja=rejestracja");
    }
    if((preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/', $_POST['haslo'])) == false){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Hasło musi zawierać co najmniej 1 dużą literę i 1 cyfrę";
        header("Location: index.php?akcja=rejestracja");
    }
    if($_POST['haslo'] != $_POST['haslo2']){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Podane hasła się różnią!";
        header("Location: index.php?akcja=rejestracja");
    }
    //Hashowanie hasła
    $hasloHash = password_hash($_POST['haslo'], PASSWORD_DEFAULT);
    //Sprawdzenie reCAPTCHA
    $key = "Tajny klucz reCAPTCHA";
    $sprawdzanie = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$_POST['g-recaptcha-response']);
    $odpowiedz = json_decode($sprawdzanie);
    if($odpowiedz->success==false){
        $walidacja = false;
        $_SESSION['bladRejestracji'] = "Potwierdź reCAPTCHA";
        header("Location: index.php?akcja=rejestracja");
    }

    //Dodanie nowego użytkownika
    if($walidacja == true){
        $szablon = $mojePolaczenie->prepare($Rejestracja);
        $szablon->bind_param("ssss", $arg1, $arg2, $arg3, $arg4);
        $arg1 = $_POST['nazwa'];
        $arg2 = $_POST['mail'];
        $arg3 = $hasloHash;
        $arg4 = $_POST['rola'];
        $szablon->execute();
        echo "<h4><br>Dodano użytkownika: " . $_POST['nazwa'] . "<br>Mail: " . $_POST['mail'] . "</h4><br>";
        $szablon->close();
        echo '<button><a href="index.php">' . $btPowrot . '</a></button>';

        //Wysyłanie maila powitalnego
        include "Includes/welcomeMail.php";
        mail($_POST['mail'], $subject, $message, $headers);
        exit();
    }
}

include "Includes/stopka.php";
?>
