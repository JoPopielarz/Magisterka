<?php
session_start();
//Sprawdzenie czy użytkownik jest zalogowany
if(!isset($_SESSION['zalogowany']))
    header("Location: ./");

include "Includes/nagl.php";
include "Includes/baza.php";
include "Includes/zapytania.php";
?>

<div class="container">
    <h2 style="text-align: center"><?php echo $txtNazwaProjektu; ?></h2>
</div>

<?php
if(($mojePolaczenie = polaczenie()) == NULL){
    header("Location: ./");
}

if($_SESSION['rola'] == "pacjent")
    include "Includes/menuPacjent.php";
else
    include "Includes/menuLekarz.php";

if(!isset($_POST['kodOperacji']) && !isset($_GET['kodOperacji']))
    header("Location: ./");

if(isset($_POST['kodOperacji']))
    $kodOperacji = $_POST['kodOperacji'];
else
    $kodOperacji = $_GET['kodOperacji'];

// Wykonanie operacji zależnie od jej kodu
$kodOperacji = (int) $kodOperacji;
switch ($kodOperacji){
    case 203:  //Edycja konta
        if($_POST['haslo'] != $_POST['haslo2']){
            echo "<h4 style=\"text-align: center\">Wprowadzone hasła się różnią - spróbuj ponownie</h4>";
            echo '<button style="margin-left: 50%"><a href="index.php?operacja=203">' . $btPowrot . '</a></button>';
        }else{
            $szablon = $mojePolaczenie->prepare($KONTOupdate);
            $szablon->bind_param("ssssssd", $val1, $val2, $val3, $val4, $val5, $val6, $val7);
            $val1 = $_POST['uzytkownik'];
            $val2 = $_POST['ImieNazwisko'];
            $val3 = $_POST['adres'];
            $val4 = $_POST['miejscowosc'];
            $val5 = $_POST['mail'];
            $val6 = $_POST['haslo'];
            $val7 = $_POST['id'];
            $szablon->execute();
            echo "Zmieniono dane użytkownika " . $_POST['uzytkownik'] . "<br>";
            $szablon->close();
            echo "Zobacz nowe dane: <br>";
            echo '<button><a href="index.php?operacja=202">' . $btMojeKonto . '</a></button>';
        }
        break;
    case 204:  //Usuwanie konta
        $szablon = $mojePolaczenie->prepare($KONTOdelete);
        $szablon->bind_param("d", $val1);
        $val1 = $_SESSION['iduzytkownika'];
        $szablon->execute();
        echo "Usunięto użytkownika " . $_SESSION['zalogowany'] . "<br>";
        $szablon->close();
        if(isset($_SESSION)){
            session_destroy();
            $_SESSION = array();
        }
        echo '<a href="index.php">' . $btPowrot . '</a>';
        break;
    case 302:  //Dodanie rekordu - tetno
        if(isset($_POST['data']) && $_POST['godzina'] && $_POST['pomiar'] && $_SESSION['iduzytkownika']){
            $szablon = $mojePolaczenie->prepare($TETNOinsert);
            $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
            $val1 = $_SESSION['iduzytkownika'];
            $val2 = $_POST['data'];
            $val3 = $_POST['godzina'];
            $val4 = $_POST['pomiar'];
            $val5 = $_SESSION['zalogowany'];
            $szablon->execute();
        }
        echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=301">' . $btPowrot . '</a>';
        break;
    case 303:  //Usunięcie rekordu - tetno
        $szablon = $mojePolaczenie->prepare($TETNOdelete);
        $szablon->bind_param("d", $val1);
        $val1 = $_GET['id'];
        $szablon->execute();
        echo "Usunięto " . $mojePolaczenie->affected_rows . " rekord[y ów]<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=default">' . $btPowrot . '</a>';
        break;

    case 402:  //Dodanie rekordu - ciśnienie
        if(isset($_POST['data']) && $_POST['godzina'] && $_POST['pomiar'] && $_SESSION['iduzytkownika']){
            $szablon = $mojePolaczenie->prepare($CISNIENIEinsert);
            $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
            $val1 = $_SESSION['iduzytkownika'];
            $val2 = $_POST['data'];
            $val3 = $_POST['godzina'];
            $val4 = $_POST['pomiar'];
            $val5 = $_SESSION['zalogowany'];
            $szablon->execute();
        }
        echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=401">' . $btPowrot . '</a>';
        break;

    case 403:  //Usuwanie rekordu - ciśnienie
        $szablon = $mojePolaczenie->prepare($CISNIENIEdelete);
        $szablon->bind_param("d", $val1);
        $val1 = $_GET['id'];
        $szablon->execute();
        echo "Usunięto " . $mojePolaczenie->affected_rows . " rekord[y ów]<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=default">' . $btPowrot . '</a>';
        break;

    case 502:  //Dodanie rekordu - saturacja
        if(isset($_POST['data']) && $_POST['godzina'] && $_POST['pomiar'] && $_SESSION['iduzytkownika']){
            $szablon = $mojePolaczenie->prepare($SATURACJAinsert);
            $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
            $val1 = $_SESSION['iduzytkownika'];
            $val2 = $_POST['data'];
            $val3 = $_POST['godzina'];
            $val4 = $_POST['pomiar'];
            $val5 = $_SESSION['zalogowany'];
            $szablon->execute();
        }
        echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=501">' . $btPowrot . '</a>';
        break;

    case 503:  //Usuwanie rekordu - saturacja
        $szablon = $mojePolaczenie->prepare($SATURACJAdelete);
        $szablon->bind_param("d", $val1);
        $val1 = $_GET['id'];
        $szablon->execute();
        echo "Usunięto " . $mojePolaczenie->affected_rows . " rekord[y ów]<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=default">' . $btPowrot . '</a>';
        break;

    case 602:  //Dodanie rekordu - cukier
        if(isset($_POST['data']) && $_POST['godzina'] && $_POST['pomiar'] && $_SESSION['iduzytkownika']){
            $szablon = $mojePolaczenie->prepare($CUKIERinsert);
            $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
            $val1 = $_SESSION['iduzytkownika'];
            $val2 = $_POST['data'];
            $val3 = $_POST['godzina'];
            $val4 = $_POST['pomiar'];
            $val5 = $_SESSION['zalogowany'];
            $szablon->execute();
        }
        echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=601">' . $btPowrot . '</a>';
        break;

    case 603:  //Usuwanie rekordu - cukier
        $szablon = $mojePolaczenie->prepare($CUKIERdelete);
        $szablon->bind_param("d", $val1);
        $val1 = $_GET['id'];
        $szablon->execute();
        echo "Usunięto " . $mojePolaczenie->affected_rows . " rekord[y ów]<br>";
        $szablon->close();
        echo '<a href="index.php?operacja=default">' . $btPowrot . '</a>';
        break;
        
    case 803:  //Dodanie rekordu - lekarz
        switch($_POST['parametr']){
            case 'tetno':
                $szablon = $mojePolaczenie->prepare($LEK_TETNOinsert);
                $szablon->bind_param("sssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_POST['pacjent'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute(); 
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=801">' . $btPowrot . '</a>';
                break;
            case 'cisnienie':
                $szablon = $mojePolaczenie->prepare($LEK_CISNIENIEinsert);
                $szablon->bind_param("sssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_POST['pacjent'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute(); 
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=801">' . $btPowrot . '</a>';
                break;
            case 'saturacja':
                $szablon = $mojePolaczenie->prepare($LEK_SATURACJAinsert);
                $szablon->bind_param("sssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_POST['pacjent'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute(); 
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=801">' . $btPowrot . '</a>';
                break;
            case 'cukier':
                $szablon = $mojePolaczenie->prepare($LEK_CUKIERinsert);
                $szablon->bind_param("sssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_POST['pacjent'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute(); 
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=801">' . $btPowrot . '</a>';
                break;
        }
        break;
        
    default:
        header("Location: ./");
}

include "Includes/stopka.php";
?>