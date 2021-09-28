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

<div class="container">
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
        //Flaga udanej walidacji konta
        $walidacja = true;
        //Sprawdzenie loginu
        if((strlen($_POST['uzytkownik'])<3) || (strlen($_POST['uzytkownik'])>20)){
            $walidacja = false;
            $_SESSION['bladEdycji'] = "Nazwa użytkownika musi posiadać od 3 do 20 znaków!";
            header("Location: index.php?operacja=203");
        }
        if(ctype_alnum($_POST['uzytkownik']) == false){
            $walidacja = false;
            $_SESSION['bladEdycji'] = "Nazwa użytkownika może składać się tylko z liter i cyfr (bez polskich znaków)";
            header("Location: index.php?operacja=203");
        }
        //Sprawdzanie adresu e-mail
        $emailSafe = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
        if((filter_var($emailSafe, FILTER_VALIDATE_EMAIL)==false) || ($emailSafe!=$_POST['mail'])){
            $walidacja = false;
            $_SESSION['bladEdycji'] = "Podaj poprawny adres e-mail!";
            header("Location: index.php?operacja=203");
        }
        //Sprawdzenie hasła
        if((strlen($_POST['haslo'])<8) || (strlen($_POST['haslo'])>20)){
            $walidacja = false;
            $_SESSION['bladEdycji'] = "Hasło musi posiadać od 8 do 20 znaków!";
            header("Location: index.php?operacja=203");
        }
        if((preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/', $_POST['haslo'])) == false){
            $walidacja = false;
            $_SESSION['bladEdycji'] = "Hasło musi zawierać co najmniej 1 dużą literę i 1 cyfrę";
            header("Location: index.php?operacja=203");
        }
        if($_POST['haslo'] != $_POST['haslo2']){
            $walidacja = false;
            $_SESSION['bladEdycji'] = "Podane hasła się różnią!";
            header("Location: index.php?operacja=203");
        }
        //Hashowanie hasła
        $hasloHash = password_hash($_POST['haslo'], PASSWORD_DEFAULT);

        if($walidacja == true){
            $szablon = $mojePolaczenie->prepare($KONTOupdate);
            $szablon->bind_param("sssd", $val1, $val2, $val3, $val4);
            $val1 = $_POST['uzytkownik'];
            $val2 = $_POST['mail'];
            $val3 = $hasloHash;
            $val4 = $_POST['id'];
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
        if(isset($_POST['data'])){
            //Walidacja wprowadzonych danych
            $walidacja = true;
            //Sprawdzenie godziny
            if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                header("Location: index.php?operacja=302");
            }
            //Sprawdzenie pomiaru
            if(ctype_digit($_POST['pomiar']) == false || ($_POST['pomiar'] < 30) || ($_POST['pomiar'] > 200)){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru (zakres 30-200)";
                header("Location: index.php?operacja=302");
            }

            if($walidacja == true){
                $szablon = $mojePolaczenie->prepare($TETNOinsert);
                $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_SESSION['iduzytkownika'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute();
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=301">' . $btPowrot . '</a>';
            }
        }
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
        if(isset($_POST['data'])){
            //Walidacja wprowadzonych danych
            $walidacja = true;
            //Sprawdzenie godziny
            if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                header("Location: index.php?operacja=402");
            }
            //Sprawdzenie pomiaru
            if((preg_match('/^(([8-9][0-9]|1[0-4][0-9])\/[4-9][0-9]|1[0-1][0-9])/', $_POST['pomiar'])) == false){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru: skurczowe/rozkurczowe (zakres skurczowe 80-149, a rozkurczowe 40-119)";
                header("Location: index.php?operacja=402");
            }

            if($walidacja == true){
                $szablon = $mojePolaczenie->prepare($CISNIENIEinsert);
                $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_SESSION['iduzytkownika'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute();
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=401">' . $btPowrot . '</a>';
            }
        }
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
        if(isset($_POST['data'])){
            //Walidacja wprowadzonych danych
            $walidacja = true;
            //Sprawdzenie godziny
            if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                header("Location: index.php?operacja=502");
            }
            //Sprawdzenie pomiaru
            if(ctype_digit($_POST['pomiar']) == false || ($_POST['pomiar'] < 10) || ($_POST['pomiar'] > 100)){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru (zakres 10-100)";
                header("Location: index.php?operacja=502");
            }

            if($walidacja == true){
                $szablon = $mojePolaczenie->prepare($SATURACJAinsert);
                $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_SESSION['iduzytkownika'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute();
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=501">' . $btPowrot . '</a>';
            }
        }
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
        if(isset($_POST['data'])){
            //Walidacja wprowadzonych danych
            $walidacja = true;
            //Sprawdzenie godziny
            if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                header("Location: index.php?operacja=602");
            }
            //Sprawdzenie pomiaru
            if(ctype_digit($_POST['pomiar']) == false || ($_POST['pomiar'] < 50) || ($_POST['pomiar'] > 170)){
                $walidacja = false;
                $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru (zakres 50-170)";
                header("Location: index.php?operacja=602");
            }

            if($walidacja == true){
                $szablon = $mojePolaczenie->prepare($CUKIERinsert);
                $szablon->bind_param("dssss", $val1, $val2, $val3, $val4, $val5);
                $val1 = $_SESSION['iduzytkownika'];
                $val2 = $_POST['data'];
                $val3 = $_POST['godzina'];
                $val4 = $_POST['pomiar'];
                $val5 = $_SESSION['zalogowany'];
                $szablon->execute();
                echo "Dodano " . $mojePolaczenie->affected_rows . " rekord<br>";
                $szablon->close();
                echo '<a href="index.php?operacja=601">' . $btPowrot . '</a>';
            }
        }
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
                $Lnazw = mysqli_query($mojePolaczenie, sprintf($RejestracjaSprawdzanie, $_POST['pacjent']));
                $liczbaNazw = mysqli_fetch_array($Lnazw)[0];
                if($liczbaNazw == 0){
                    $walidacja = false;
                    $_SESSION['bladEdycji'] = "Wprowadź poprawny login pacjenta";
                    header("Location: index.php?operacja=803");
                }


                if(isset($_POST['data'])){
                    //Walidacja wprowadzonych danych
                    $walidacja = true;
                    //Sprawdzenie godziny
                    if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                        header("Location: index.php?operacja=803");
                    }
                    //Sprawdzenie pomiaru
                    if(ctype_digit($_POST['pomiar']) == false || ($_POST['pomiar'] < 30) || ($_POST['pomiar'] > 200)){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru (zakres 30-200)";
                        header("Location: index.php?operacja=803");
                    }
        
                    if($walidacja == true){
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
                    }
                }
                break;
            case 'cisnienie':
                if(isset($_POST['data'])){
                    //Walidacja wprowadzonych danych
                    $walidacja = true;
                    //Sprawdzenie godziny
                    if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                        header("Location: index.php?operacja=803");
                    }
                    //Sprawdzenie pomiaru
                    if((preg_match('/^(([8-9][0-9]|1[0-4][0-9])\/[4-9][0-9]|1[0-1][0-9])/', $_POST['pomiar'])) == false){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru: skurczowe/rozkurczowe (zakres skurczowe 80-149, a rozkurczowe 40-119)";
                        header("Location: index.php?operacja=803");
                    }
        
                    if($walidacja == true){
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
                    }
                }
                    break;
            case 'saturacja':
                if(isset($_POST['data'])){
                    //Walidacja wprowadzonych danych
                    $walidacja = true;
                    //Sprawdzenie godziny
                    if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                        header("Location: index.php?operacja=803");
                    }
                    //Sprawdzenie pomiaru
                    if(ctype_digit($_POST['pomiar']) == false || ($_POST['pomiar'] < 10) || ($_POST['pomiar'] > 100)){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru (zakres 10-100)";
                        header("Location: index.php?operacja=803");
                    }
        
                    if($walidacja == true){
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
                    }
                }
                break;
            case 'cukier':
                if(isset($_POST['data'])){
                    //Walidacja wprowadzonych danych
                    $walidacja = true;
                    //Sprawdzenie godziny
                    if((preg_match('/^((0[0-9]|1[0-9]|2[0-3])[.][0-5][0-9])/', $_POST['godzina'])) == false){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź godzinę w formacie gg.mm";
                        header("Location: index.php?operacja=803");
                    }
                    //Sprawdzenie pomiaru
                    if(ctype_digit($_POST['pomiar']) == false || ($_POST['pomiar'] < 50) || ($_POST['pomiar'] > 170)){
                        $walidacja = false;
                        $_SESSION['bladEdycji'] = "Wprowadź prawidłową wartość pomiaru (zakres 50-170)";
                        header("Location: index.php?operacja=803");
                    }
        
                    if($walidacja == true){
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
                    }
                }
                break;
        }
        break;
        
    default:
        header("Location: ./");
}
?>
</div>

<div class="container">
  <?php
    include "Includes/stopka.php";
  ?>
</div>