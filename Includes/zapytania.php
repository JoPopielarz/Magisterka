<?php
//LOGOWANIE I REJESTRACJA
$Logowanie = "SELECT * FROM uzytkownicy WHERE NazwaUzytkownika = '%s'";
$Rejestracja = "INSERT INTO uzytkownicy (NazwaUzytkownika, Mail, Haslo, Rola, ImieNazwisko, Adres, Miejscowosc) VALUES (?, ?, ?, ?, ?, ?, ?)";
$RejestracjaSprawdzanie = "SELECT COUNT(*) FROM uzytkownicy WHERE NazwaUzytkownika = '%s'";

//KONTO
$KONTOselect = "SELECT * FROM uzytkownicy WHERE iduzytkownika = %d";
$KONTOupdate = "UPDATE uzytkownicy SET NazwaUzytkownika = ?, ImieNazwisko = ?, Adres = ?, Miejscowosc = ?, Mail = ?, Haslo = ? WHERE iduzytkownika = ?";
$KONTOdelete = "DELETE FROM uzytkownicy WHERE iduzytkownika = ?";
$KONTOidnazwa = "SELECT iduzytkownika FROM uzytkownicy WHERE NazwaUzytkownika = '%s'";

//TETNO - wyświetl, dodaj, usuń
$TETNOselect = "SELECT * FROM tetno WHERE iduzytkownika = %d ORDER BY DataPomiaru DESC LIMIT 30 OFFSET %d";
$TETNOtotal_pages = "SELECT COUNT(*) FROM tetno WHERE iduzytkownika = '%d'";
$TETNOinsert = "INSERT INTO tetno (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES (?, ?, ?, ?, ?)";
$TETNOdelete = "DELETE FROM tetno WHERE idtetno = ?";

//CISNIENIE - wyświetl, dodaj, usuń
$CISNIENIEselect = "SELECT * FROM cisnienie WHERE iduzytkownika = %d ORDER BY DataPomiaru DESC LIMIT 30 OFFSET %d";
$CISNIENIEtotal_pages = "SELECT COUNT(*) FROM cisnienie WHERE iduzytkownika = '%d'";
$CISNIENIEinsert = "INSERT INTO cisnienie (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES (?, ?, ?, ?, ?)";
$CISNIENIEdelete = "DELETE FROM cisnienie WHERE idcisnienie = ?";

//SATURACJA - wyświetl, dodaj, usuń
$SATURACJAselect = "SELECT * FROM saturacja WHERE iduzytkownika = %d ORDER BY DataPomiaru DESC LIMIT 30 OFFSET %d";
$SATURACJAtotal_pages = "SELECT COUNT(*) FROM saturacja WHERE iduzytkownika = '%d'";
$SATURACJAinsert = "INSERT INTO saturacja (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES (?, ?, ?, ?, ?)";
$SATURACJAdelete = "DELETE FROM saturacja WHERE idsaturacja = ?";

//CUKIER - wyświetl, dodaj, usuń
$CUKIERselect = "SELECT * FROM cukier WHERE iduzytkownika = %d ORDER BY DataPomiaru DESC LIMIT 30 OFFSET %d";
$CUKIERtotal_pages = "SELECT COUNT(*) FROM cukier WHERE iduzytkownika = '%d'";
$CUKIERinsert = "INSERT INTO cukier (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES (?, ?, ?, ?, ?)";
$CUKIERdelete = "DELETE FROM cukier WHERE idcukier = ?";

//PARAMETRY - wyszukiwanie
$TETNOselect1 = "SELECT uzytkownicy.NazwaUzytkownika, tetno.* FROM uzytkownicy, tetno WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = tetno.iduzytkownika ORDER BY DataPomiaru DESC";
$TETNOselect2 = "SELECT uzytkownicy.NazwaUzytkownika, tetno.* FROM uzytkownicy, tetno WHERE NazwaUzytkownika = '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = tetno.iduzytkownika ORDER BY DataPomiaru DESC";
$TETNOselect3 = "SELECT uzytkownicy.NazwaUzytkownika, tetno.* FROM uzytkownicy, tetno WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = tetno.iduzytkownika ORDER BY DataPomiaru DESC";

$CISNIENIEselect1 = "SELECT uzytkownicy.NazwaUzytkownika, cisnienie.* FROM uzytkownicy, cisnienie WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = cisnienie.iduzytkownika ORDER BY DataPomiaru DESC";
$CISNIENIEselect2 = "SELECT uzytkownicy.NazwaUzytkownika, cisnienie.* FROM uzytkownicy, cisnienie WHERE NazwaUzytkownika = '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = cisnienie.iduzytkownika ORDER BY DataPomiaru DESC";
$CISNIENIEselect3 = "SELECT uzytkownicy.NazwaUzytkownika, cisnienie.* FROM uzytkownicy, cisnienie WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = cisnienie.iduzytkownika ORDER BY DataPomiaru DESC";

$SATURACJAselect1 = "SELECT uzytkownicy.NazwaUzytkownika, saturacja.* FROM uzytkownicy, saturacja WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = saturacja.iduzytkownika ORDER BY DataPomiaru DESC";
$SATURACJAselect2 = "SELECT uzytkownicy.NazwaUzytkownika, saturacja.* FROM uzytkownicy, saturacja WHERE NazwaUzytkownika = '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = saturacja.iduzytkownika ORDER BY DataPomiaru DESC";
$SATURACJAselect3 = "SELECT uzytkownicy.NazwaUzytkownika, saturacja.* FROM uzytkownicy, saturacja WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = saturacja.iduzytkownika ORDER BY DataPomiaru DESC";

$CUKIERselect1 = "SELECT uzytkownicy.NazwaUzytkownika, cukier.* FROM uzytkownicy, cukier WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = cukier.iduzytkownika ORDER BY DataPomiaru DESC";
$CUKIERselect2 = "SELECT uzytkownicy.NazwaUzytkownika, cukier.* FROM uzytkownicy, cukier WHERE NazwaUzytkownika = '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = cukier.iduzytkownika ORDER BY DataPomiaru DESC";
$CUKIERselect3 = "SELECT uzytkownicy.NazwaUzytkownika, cukier.* FROM uzytkownicy, cukier WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND Pomiar >= '%s' AND uzytkownicy.iduzytkownika = cukier.iduzytkownika ORDER BY DataPomiaru DESC";

//LEKARZ - wyświetlanie i wyszukiwanie danych
$LEKARZselectData = "SELECT uzytkownicy.NazwaUzytkownika, 'Tętno' AS Parametr, tetno.* FROM uzytkownicy, tetno WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = tetno.iduzytkownika
            UNION SELECT uzytkownicy.NazwaUzytkownika, 'Ciśnienie' AS `Parametr`, cisnienie.* FROM `uzytkownicy`, `cisnienie` WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = cisnienie.iduzytkownika
            UNION SELECT uzytkownicy.NazwaUzytkownika, 'Saturacja' AS `Parametr`, saturacja.* FROM `uzytkownicy`, `saturacja` WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = saturacja.iduzytkownika
            UNION SELECT uzytkownicy.NazwaUzytkownika, 'Cukier' AS `Parametr`, cukier.* FROM `uzytkownicy`, `cukier` WHERE NazwaUzytkownika = '%s' AND DataPomiaru >= '%s' AND uzytkownicy.iduzytkownika = cukier.iduzytkownika ORDER BY `DataPomiaru` DESC LIMIT 30 OFFSET %d";

$LEK_TETNOtotal_pages = "SELECT COUNT(*) FROM tetno WHERE iduzytkownika = '%d' AND DataPomiaru >= '%s'";
$LEK_CISNIENIEtotal_pages = "SELECT COUNT(*) FROM cisnienie WHERE iduzytkownika = '%d' AND DataPomiaru >= '%s'";
$LEK_SATURACJAtotal_pages = "SELECT COUNT(*) FROM saturacja WHERE iduzytkownika = '%d' AND DataPomiaru >= '%s'";
$LEK_CUKIERtotal_pages = "SELECT COUNT(*) FROM cukier WHERE iduzytkownika = '%d' AND DataPomiaru >= '%s'";

//LEKARZ - dodaj rekord
$LEK_TETNOinsert = "INSERT INTO tetno (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES ((SELECT uzytkownicy.iduzytkownika FROM uzytkownicy WHERE NazwaUzytkownika = ?), ?, ?, ?, ?)";
$LEK_CISNIENIEinsert = "INSERT INTO cisnienie (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES ((SELECT uzytkownicy.iduzytkownika FROM uzytkownicy WHERE NazwaUzytkownika = ?), ?, ?, ?, ?)";
$LEK_SATURACJAinsert = "INSERT INTO saturacja (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES ((SELECT uzytkownicy.iduzytkownika FROM uzytkownicy WHERE NazwaUzytkownika = ?), ?, ?, ?, ?)";
$LEK_CUKIERinsert = "INSERT INTO cukier (iduzytkownika, DataPomiaru, Godzina, Pomiar, Wprowadzil) VALUES ((SELECT uzytkownicy.iduzytkownika FROM uzytkownicy WHERE NazwaUzytkownika = ?), ?, ?, ?, ?)";

//LEKARZ - Wyszukiwanie pacjenta
$PACJENTselect = "SELECT * FROM uzytkownicy WHERE NazwaUzytkownika = '%s' OR ImieNazwisko = '%s'";
?>