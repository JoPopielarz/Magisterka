<?php
    session_start();
    include "Includes/nagl.php";
    include "Includes/baza.php";
    include "Includes/zapytania.php";
?>

<div class="container">
    <h2 style="text-align: center"><?php echo $txtNazwaProjektu; ?></h2>
</div>

<div class="container">
<?php
if(!isset($_SESSION['zalogowany']) && (!isset($_GET['operacja']) || !isset($_POST['operacja']))){
  echo "<h3>Dzień dobry!</h3>";
  include "Login.php";
}else{
  if(($mojePolaczenie = polaczenie()) == NULL){
      echo $_SESSION['bladPolaczenia'];
    }
  $nazwaUzytkownika = $_SESSION['zalogowany'];
  $iduzytkownika = $_SESSION['iduzytkownika'];
  $RolaUzytkownika = $_SESSION['rola'];

  if($RolaUzytkownika == "pacjent")
    include "Includes/menuPacjent.php";
  elseif($RolaUzytkownika == "lekarz")
    include "Includes/menuLekarz.php";
  
  echo "<br>";

  if(isset($_GET['operacja']))
    $kodOperacji = $_GET['operacja'];
  elseif(isset($_POST['operacja']))
    $kodOperacji = $_POST['operacja'];
  else
    $kodOperacji = "default";

  switch($kodOperacji){
    case 201:  //Wylogowanie
      include "Wyloguj.php";
      break;
    case 202:  //Moje konto
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($KONTOselect, $iduzytkownika))){
        include "Includes/naglTabKonto.php";
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                $wiersz['iduzytkownika'], $wiersz['NazwaUzytkownika'], $wiersz['ImieNazwisko'], $wiersz['Adres'], 
                $wiersz['Miejscowosc'], $wiersz['Mail'], $wiersz['Rola']);
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 203:  //Edycja konta
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($KONTOselect, $iduzytkownika))){
        include "Includes/naglTabKonto.php";
        $wiersz = $wynik->fetch_assoc();
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                $wiersz['iduzytkownika'], $wiersz['NazwaUzytkownika'], $wiersz['ImieNazwisko'], $wiersz['Adres'], 
                $wiersz['Miejscowosc'], $wiersz['Mail'], $wiersz['Rola']);
        echo "</tbody></table>";
        include "forms/frmEdytujKonto.php";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 204:  //Usuwanie konta
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($KONTOselect, $iduzytkownika))){
        include "Includes/naglTabKonto.php";
        $wiersz = $wynik->fetch_assoc();
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                $wiersz['iduzytkownika'], $wiersz['NazwaUzytkownika'], $wiersz['ImieNazwisko'], $wiersz['Adres'], 
                $wiersz['Miejscowosc'], $wiersz['Mail'], $wiersz['Rola']);
        echo "</tbody></table>";
        echo "<h4 style=\"text-align: center\">Czy na pewno chcesz usunąć swoje konto?</h4>";
        echo '<button style="margin-left: 50%"><a href="operacjeDB.php?kodOperacji=204">' . $btUsun . '</a></button>';
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 301:  //Wyświetlanie danych - tętno
      echo "Norma tętna: " . $txtTetnoNorma . "<br>";
      echo '<button class="btn" type="button" id="Wyszukaj" style="margin-left: 90%"><a href="index.php?operacja=3011">' . $btFrmWyszukaj . '</a></button>';
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($TETNOselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryWysw.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="301">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($TETNOtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="301">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;
    case 3011:  //Wyszukiwanie rekordu - tetno
      include "forms/frmWyszukajTetno.php";
      break;
    case 3012:
      if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect1, $_SESSION['zalogowany'], $_POST['data']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect2, $_SESSION['zalogowany'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect3, $_SESSION['zalogowany'], $_POST['data'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }else
        echo "Proszę doprecyzować wyszukiwanie";
      break;

    case 302:  //Dodanie rekordu - tetno
      include "forms/frmDodajTetno.php";
      break;

    case 303:  //Usuwanie rekordu - tetno
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($TETNOselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryUsun.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=303\">" . $btUsun . "</a></td></tr>",
                $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idtetno']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="303">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($TETNOtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" mathod="get">
            <input type="hidden" name="operacja" value="303">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 401:  //Wyświetlanie danych - ciśnienie
      echo "Norma ciśnienia: " . $txtCisnienieNorma . "<br>";
      echo '<button class="btn" type="button" id="Wyszukaj" style="margin-left: 90%"><a href="index.php?operacja=4011">' . $btFrmWyszukaj . '</a></button>';
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($CISNIENIEselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryWysw.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="401">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($CISNIENIEtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="401">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 4011:  //Wyszukiwanie rekordu - ciśnienie
      include "forms/frmWyszukajCisnienie.php";
      break;
    case 4012:
      if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect1, $_SESSION['zalogowany'], $_POST['data']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect2, $_SESSION['zalogowany'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect3, $_SESSION['zalogowany'], $_POST['data'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }else
        echo "Proszę doprecyzować wyszukiwanie";
      break;

    case 402:  //Dodanie rekordu - ciśnienie
      include "forms/frmDodajCisnienie.php";
      break;

    case 403:  //Usuwanie rekordu - ciśnienie
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($CISNIENIEselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryUsun.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=403\">" . $btUsun . "</a></td></tr>",
                $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idcisnienie']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="403">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($CISNIENIEtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" mathod="get">
            <input type="hidden" name="operacja" value="403">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 501:  //Wyświetlanie danych - saturacja
      echo "Norma saturacji: " . $txtSaturacjaNorma . "<br>";
      echo '<button class="btn" type="button" id="Wyszukaj" style="margin-left: 90%"><a href="index.php?operacja=5011">' . $btFrmWyszukaj . '</a></button>';
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($SATURACJAselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryWysw.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="501">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($SATURACJAtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="501">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 5011:  //Wyszukiwanie rekordu - saturacja
      include "forms/frmWyszukajSaturacja.php";
      break;

    case 5012:
      if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect1, $_SESSION['zalogowany'], $_POST['data']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect2, $_SESSION['zalogowany'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect3, $_SESSION['zalogowany'], $_POST['data'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }else
        echo "Proszę doprecyzować wyszukiwanie";
      break;

    case 502:  //Dodanie rekordu - saturacja
      include "forms/frmDodajSaturacja.php";
      break;

    case 503:  //Usuwanie rekordu - saturacja
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($SATURACJAselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryUsun.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=503\">" . $btUsun . "</a></td></tr>",
                $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idsaturacja']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="503">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($SATURACJAtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" mathod="get">
            <input type="hidden" name="operacja" value="503">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 601:  //Wyświetlanie danych - cukier
      echo "Norma poziomu cukru: " . $txtCukierNorma . "<br>";
      echo '<button class="btn" type="button" id="Wyszukaj" style="margin-left: 90%"><a href="index.php?operacja=6011">' . $btFrmWyszukaj . '</a></button>';
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($CUKIERselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryWysw.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="601">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($CUKIERtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="601">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 6011:  //Wyszukiwanie rekordu - cukier
      include "forms/frmWyszukajCukier.php";
      break;

    case 6012:
      if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect1, $_SESSION['zalogowany'], $_POST['data']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect2, $_SESSION['zalogowany'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect3, $_SESSION['zalogowany'], $_POST['data'], $_POST['pomiar']))){
          include "Includes/naglTabParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }else
        echo "Proszę doprecyzować wyszukiwanie";
      break;

    case 602:  //Dodanie rekordu - cukier
      include "forms/frmDodajCukier.php";
      break;

    case 603:  //Usuwanie rekordu - cukier
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
        sprintf($CUKIERselect, $offset);
      }
      if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect, $iduzytkownika, $offset))){
        include "Includes/naglTabParametryUsun.php";
        //Wyświetlanie wszystkich wierszy
        while($wiersz = $wynik->fetch_assoc()){
          printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=603\">" . $btUsun . "</a></td></tr>",
                $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idcukier']);
        }
        echo "<br>";
        //Poprzednia strona
        if($offset != 0){
          ?>
          <form action="index.php" method="get">
            <input type="hidden" name="operacja" value="603">
            <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
            <input type="submit" value="Poprzednie">
          </form>
          <?php
        }
        //Następna strona
        $Lstron = mysqli_query($mojePolaczenie, sprintf($CUKIERtotal_pages, $iduzytkownika));
        $liczbastron = mysqli_fetch_array($Lstron)[0] - (31);
        if($offset <= $liczbastron){
          ?>
          <form action="index.php" mathod="get">
            <input type="hidden" name="operacja" value="603">
            <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
            <input type="submit" value="Następne">
          </form>
          <?php
        }
        echo "</tbody></table>";
        $mojePolaczenie->close();
      }else
        echo $txtBladZapytania;
      break;

    case 701:  //Dokumentacja - pacjent
      include "Documentation/dokumentacjaPacjent.php";
      break;
  
    case 801:  //Wyświetlanie pomiarów pacjenta
      echo "<h4>Wprowadź dane pacjenta:</h4>";
      include "forms/frmWyswPacjenta.php";
      break;
    case 8011:
      if(!isset($_GET['offset']) && !isset($_POST['offset']))
        $offset = 0;
      if(isset($_GET['offset']))
        $offset = $_GET['offset'];
      if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
      }
      
      if(isset($_POST['pacjent']) && isset($_POST['odkiedy'])){
        echo "<h4>Dane pacjenta: " . $_POST['pacjent'] . "</h4><br>";
        $User = mysqli_query($mojePolaczenie, sprintf($KONTOidnazwa, $_POST['pacjent']));
        $idUser = mysqli_fetch_array($User)[0];
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($LEKARZselectData, $_POST['pacjent'], $_POST['odkiedy'], $_POST['pacjent'], $_POST['odkiedy'], $_POST['pacjent'], $_POST['odkiedy'], $_POST['pacjent'], $_POST['odkiedy'], $offset))){
          include "Includes/naglTabLekParametryWysw.php";
          while($wiersz = $wynik->fetch_assoc()){
              printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['idtetno'], $wiersz['Parametr'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
          }
          //Poprzednia strona
          if($offset != 0){
            ?>
            <form action="index.php" method="post">
              <input type="hidden" name="pacjent" value="<?php echo $_POST['pacjent']; ?>">
              <input type="hidden" name="odkiedy" value="<?php echo $_POST['odkiedy']; ?>">
              <input type="hidden" name="operacja" value="8011">
              <input type="hidden" name="offset" value="<?php echo ($offset - 30); ?>">
              <input type="submit" value="Poprzednie">
            </form>
            <?php
          }
          //Następna strona
          $LstrTetno = mysqli_query($mojePolaczenie, sprintf($LEK_TETNOtotal_pages, $idUser, $_POST['odkiedy']));
          $liczbastronTetno = mysqli_fetch_array($LstrTetno)[0];
          $LstrCisnienie = mysqli_query($mojePolaczenie, sprintf($LEK_CISNIENIEtotal_pages, $idUser, $_POST['odkiedy']));
          $liczbastronCisnienie = mysqli_fetch_array($LstrCisnienie)[0];
          $LstrSaturacja = mysqli_query($mojePolaczenie, sprintf($LEK_SATURACJAtotal_pages, $idUser, $_POST['odkiedy']));
          $liczbastronSaturacja = mysqli_fetch_array($LstrSaturacja)[0];
          $LstrCukier = mysqli_query($mojePolaczenie, sprintf($LEK_CUKIERtotal_pages, $idUser, $_POST['odkiedy']));
          $liczbastronCukier = mysqli_fetch_array($LstrCukier)[0];
          $liczbastron = $liczbastronTetno + $liczbastronCisnienie + $liczbastronSaturacja + $liczbastronCukier - 31;
          if($offset <= $liczbastron){
            ?>
            <form action="index.php" method="post">
              <input type="hidden" name="pacjent" value="<?php echo $_POST['pacjent']; ?>">
              <input type="hidden" name="odkiedy" value="<?php echo $_POST['odkiedy']; ?>">
              <input type="hidden" name="operacja" value="8011">
              <input type="hidden" name="offset" value="<?php echo ($offset + 30); ?>">
              <input type="submit" value="Następne">
            </form>
            <?php
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }
      break;

    case 802:  //Wyszukiwanie danych
      include "forms/frmWyszukajDane.php";
      break;
    case 8021:
      switch($_POST['parametr']){
        case 'tetno':
          echo "<h4>Pomiary tętna pacjenta: " . $_POST['pacjent'] . "</h4>";
          if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect1, $_POST['pacjent'], $_POST['data']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect2, $_POST['pacjent'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect3, $_POST['pacjent'], $_POST['data'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }else
            echo "Proszę doprecyzować wyszukiwanie";
          break;
        case 'cisnienie':
          echo "<h4>Pomiary ciśnienia pacjenta: " . $_POST['pacjent'] . "</h4>";
          if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect1, $_POST['pacjent'], $_POST['data']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect2, $_POST['pacjent'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect3, $_POST['pacjent'], $_POST['data'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }else
            echo "Proszę doprecyzować wyszukiwanie";
          break;
        case 'saturacja':
          echo "<h4>Pomiary saturacji pacjenta: " . $_POST['pacjent'] . "</h4>";
          if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect1, $_POST['pacjent'], $_POST['data']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect2, $_POST['pacjent'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect3, $_POST['pacjent'], $_POST['data'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }else
            echo "Proszę doprecyzować wyszukiwanie";
          break;
        case 'cukier':
          echo "<h4>Pomiary poziomu cukru pacjenta: " . $_POST['pacjent'] . "</h4>";
          if($_POST['data'] != NULL && $_POST['pomiar'] == NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect1, $_POST['pacjent'], $_POST['data']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] == NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect2, $_POST['pacjent'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }elseif($_POST['data'] != NULL && $_POST['pomiar'] != NULL){
            if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect3, $_POST['pacjent'], $_POST['data'], $_POST['pomiar']))){
              include "Includes/naglTabParametryWysw.php";
              while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                      $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil']);
              }
              echo "</tbody></table>";
              $mojePolaczenie->close();
            }else
              echo $txtBladZapytania;
          }else
            echo "Proszę doprecyzować wyszukiwanie";
          break;
      }
      break;

    case 803:  //Dodanie rekordu - lekarz
      include "forms/frmLekDodajRekord.php";
      break;

    case 804:  //Usuwanie rekordu - lekarz
      include "forms/frmLekUsunRekord.php";
      break;
    case 8041:
      echo "<h4>Dane pacjenta: " . $_POST['pacjent'] . "</h4>";
      switch($_POST['parametr']){
        case 'tetno':
          if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($TETNOselect1, $_POST['pacjent'], $_POST['odkiedy']))){
            include "Includes/naglTabParametryUsun.php";
            while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=303\">" . $btUsun . "</a></td></tr>",
                    $wiersz['idtetno'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idtetno']);
            }
            echo "</tbody></table>";
            $mojePolaczenie->close();
          }else
            echo $txtBladZapytania;
          break;
        case 'cisnienie':
          if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CISNIENIEselect1, $_POST['pacjent'], $_POST['odkiedy']))){
            include "Includes/naglTabParametryUsun.php";
            while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=403\">" . $btUsun . "</a></td></tr>",
                    $wiersz['idcisnienie'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idcisnienie']);
            }
            echo "</tbody></table>";
            $mojePolaczenie->close();
          }else
            echo $txtBladZapytania;
          break;
        case 'saturacja':
          if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($SATURACJAselect1, $_POST['pacjent'], $_POST['odkiedy']))){
            include "Includes/naglTabParametryUsun.php";
            while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=503\">" . $btUsun . "</a></td></tr>",
                    $wiersz['idsaturacja'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idsaturacja']);
            }
            echo "</tbody></table>";
            $mojePolaczenie->close();
          }else
            echo $txtBladZapytania;
          break;
        case 'cukier':
          if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($CUKIERselect1, $_POST['pacjent'], $_POST['odkiedy']))){
            include "Includes/naglTabParametryUsun.php";
            while($wiersz = $wynik->fetch_assoc()){
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"operacjeDB.php?id=%d&kodOperacji=603\">" . $btUsun . "</a></td></tr>",
                    $wiersz['idcukier'], $wiersz['DataPomiaru'], $wiersz['Godzina'], $wiersz['Pomiar'], $wiersz['Wprowadzil'], $wiersz['idcukier']);
            }
            echo "</tbody></table>";
            $mojePolaczenie->close();
          }else
            echo $txtBladZapytania;
          break;
      }
      break;

    case 805:  //Wyszukaj pacjenta
      include "forms/frmWyszukajPacjenta.php";
      break;

    case 8051:
      if(($_POST['uzytkownik'] != '') || ($_POST['imie'] != '')){
        if($wynik = zapytanieDoBazy($mojePolaczenie, sprintf($PACJENTselect, $_POST['uzytkownik'], $_POST['imie']))){
          include "Includes/naglTabKonto.php";
          while($wiersz = $wynik->fetch_assoc()){
            printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
                  $wiersz['iduzytkownika'], $wiersz['NazwaUzytkownika'], $wiersz['ImieNazwisko'], $wiersz['Adres'], 
                  $wiersz['Miejscowosc'], $wiersz['Mail'], $wiersz['Rola']);
          }
          echo "</tbody></table>";
          $mojePolaczenie->close();
        }else
          echo $txtBladZapytania;
      }else{
        echo '<h4 style="text-align: center">Nie wprowadzono danych do wyszukania</h4><br>';
        echo '<button style="margin-left: 50%"><a href="index.php?operacja=805">' . $btPowrot . '</a></button>';
      }
      break;

    case 901:  //Dokumentacja - lekarz
      include "Documentation/dokumentacjaLekarz.php";
      break;

    default:
      echo "<h3 style=\"text-align: center\">Witaj, co chcesz dzisiaj zrobić?</h3>";
  }
}
       
?>
</div>
<div class="container">
<?php
    include "Includes/stopka.php";
?>