<div style="text-align: justify">Projekt aplikacji „BioApp” powstał w ramach pracy dyplomowej magisterskiej inż. Joanny 
Popielarz pod opieką dr inż. Stanisława Flagi. </br>

<br><b>Opis operacji</br>

Logowanie i rejestracja:</b>
<br>Pierwszą funkcją w „index.php” jest sprawdzenie za pomocą if i isset czy użytkownik jest zalogowany. 
Jeśli użytkownik nie jest zalogowany warunek jest spełniony i dołączony zostaje plik „Login.php”. 
Jeśli użytkownik jest zalogowany dołączony zostaje plik z menu strony głównej. Plik „Login.php” wyświetla się formularz 
logowania i rejestracji wraz z przyciskami. Jeśli użytkownik wypełni pola i użyje przycisku „Zaloguj” zostanie aktywowany 
plik „ObslugaLogowania.php”. W nim sprawdzamy poprzez zapytanie do bazy z wykorzystaniem zapytania ukrytego pod zmienną 
$Logowanie czy użytkownik o takiej nazwie znajduje się w bazie. Po rozpoznaniu użytkownika zmienna SESSION przechowuje 
dane o użytkowniku jako zmienną globalną widoczną na wielu stronach. Wyświetlona zostaje strona główna aplikacji – 
operacja „default” w pliku „index.php”.
<br>Wybierając przycisk „Zarejestruj” po wcześniejszym wypełnieniu danych dołączony zostaje plik „Rejestracja.php”, 
w którym za pomocą zapytania Insert ukrytego pod zmienną $Rejestracja dodajemy rekordy do tabeli uzytkownicy w bazie 
danych oraz powracamy do strony z logowaniem.</br>

<br><b>Zakładka Konto:</b>
<br>Zakładka ta zawiera listę operacji dotyczących konta użytkownika, takich jak wylogowanie, wyświetlanie i edycja 
danych oraz usuwanie konta.</br>
<br><i>Zakładka „Wyloguj”</i> jest operacją 201 w pliku „index.php”. Dołącza ona plik „Wyloguj.php”, który usuwa zapis 
sesji, wyświetla komunikat o poprawnym wylogowaniu oraz przycisk „Zaloguj ponownie”. Po użyciu tego przycisku użytkownik 
zostaje przekierowany do pliku „index.php”.</br>
<br><i>Zakładka „Moje konto”</i> służy do wyświetlania danych aktualnie zalogowanego użytkownika. Jest to operacja 202 
w „index.php”. Za pomocą zapytania SELECT polecenie wypisuje zawartość tabeli użytkownicy w bazie danych, ograniczoną do 
jednego rekordu.</br>
<br><i>Zakładka „Edytuj konto”</i> to operacja 203 w „index.php”. Polecenie wypisuje zawartość tabeli użytkownicy w bazie 
danych zapytaniem SELECT. Poniżej dołączony jest formularz „frmEdytujKonto.php”, zawierający pola do podania nazwy 
użytkownika, adresu e-mail oraz dwa pola hasła. Wszystkie dane muszą zostać podane przed użyciem przycisku „Potwierdź”. 
Przycisk ten odsyła do operacji 203 w „operacjeDB.php”. Wartości wprowadzone w polach hasła są porównywane, jeśli się 
różnią wyświetlany jest komunikat oraz przycisk „POWRÓT” odsyłający do operacji 203 w pliku „index.php”. Natomiast jeśli 
hasła się zgadzają zostaje przygotowane zapytanie UPDATE dla bazy danych. Wartości podane przez użytkownika w formularzu 
oraz id ze zmiennej globalnej $_SESSION[‘iduzytkownika’] ustawiane są jako parametr tego zapytania za pomocą funkcji 
bind_param.</br>
<br><i>Zakładka „Usuń konto”</i> jest operacją 204 w pliku „index.php”, która wyświetla dane aktualnie zalogowanego 
użytkownika z tabeli użytkownicy, komunikat proszący o potwierdzenie działania oraz przycisk „USUŃ” odsyłający do operacji 
204 w „operacjeDB.php”, usuwającej za pomocą zapytania DELETE użytkownika o id ze zmiennej globalnej 
$_SESSION[‘iduzytkownika’] z tabeli uzytkownicy.</br>

<br><b>Zakładka Pacjent:</b>
<br>Zakładka „Pacjent” zawiera listę operacji związanych z pomiarami pacjentów. Po jej rozwinięciu można wybrać: 
wyświetlanie lub wyszukiwanie danych, dodawanie lub usuwanie pomiaru oraz wyszukiwanie danych pacjenta.</br>
<br><i>Zakładka „Wyświetl dane”</i> to operacja 801 w pliku „index.php”. Dołącza ona formularz „frmWyswPacjenta.php”, 
zawierający pola do podania nazwy pacjenta oraz daty, od której będą wyświetlone pomiary. Przycisk „Wyszukaj” odsyła 
do operacji 8011 w „index.php”, która wypisuje zawartości tabel parametrów z bazy danych, ograniczone do podanego pacjenta 
i daty. Na stronie wyświetlane jest 30 rekordów, poprzez ograniczenie zapytania SELECT w postaci zmiennej $offset, 
z możliwością przejścia do następnej strony lub cofania się. W tabeli wyświetlana jest także kolumna z nazwą parametru 
zapisanego pomiaru.</br>
<br><i>Zakładka „Wyszukaj dane”</i> jest operacją 802 w „index.php”, odpowiadającą za załączenie formularza 
„frmWyszukajDane.php”. Formularz ten składa się z pól: login pacjenta, parametr, data od której zostaną wyszukane pomiary 
oraz minimalna wartość pomiaru. Ponadto zawiera on przycisk „Wyszukaj” odsyłający do operacji 8021, która za pomocą 
zapytania SELECT wyświetla rekordy podanego parametru i pacjenta od podanej daty lub od wprowadzonej minimalnej wartości 
pomiaru.</br>
<br><i>Zakładka „Dodaj pomiar”</i> odpowiada operacji 803 w „index.php”, która dołącza formularz „frmLekDodajRekord.php”. 
Wyświetlone zostają pola do wprowadzenia danych nowego rekordu: login pacjenta, parametr, data, godzina i wartość 
pomiaru. Za pomocą przycisku „Zapisz” dane te są przesyłane do operacji 803 w pliku „operacjeDB.php”, gdzie za pomocą 
zapytania INSERT dodany zostaje rekord z wprowadzonymi w formularzu danymi do odpowiedniej tabeli w bazie danych.</br>
<br><i>Zakładka „Usuń pomiar”</i> to operacja 804 w pliku „index.php”, dołączająca formularz z polami loginu pacjenta, 
parametru oraz daty, od której pomiary mają zostać wyświetlone. Po aktywowaniu przycisku „Wyszukaj”, za pomocą operacji 
8041, wyświetlona jest zawartość odpowiedniej tabeli w bazie danych, ograniczona do podanych w formularzu warunków. Obok 
rekordów wypisana jest dodatkowa akcja „USUŃ”, która inicjuje operację 303 w „operacjeDB.php”. Operacja ta za pomocą 
zapytania DELETE usuwa rekord o id przesłanym podczas aktywowania przycisku.</br>
<br>Po wybraniu <i>zakładki „Wyszukaj pacjenta”</i> operacja 805 w „index.php” załącza formularz z polami loginu pacjenta 
oraz imienia i nazwiska. Przycisk „Wyszukaj” odsyła do operacji 8051, która sprawdza czy przynajmniej jedno pole zostało 
uzupełnione, a następnie korzysta zapytania SELECT i wyświetla wszystkie rekordy o takim loginie lub imieniu i nazwisku 
z tabeli uzytkownicy. </br>
<br>
</div>