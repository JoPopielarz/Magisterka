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
użytkownika, imienia i nazwiska, adresu, miejscowości, adresu e-mail oraz dwa pola hasła. Wszystkie dane muszą zostać 
podane przed użyciem przycisku „Potwierdź”. Przycisk ten odsyła do operacji 203 w „operacjeDB.php”. Wartości wprowadzone 
w polach hasła są porównywane, jeśli się różnią wyświetlany jest komunikat oraz przycisk „POWRÓT” odsyłający do operacji 
203 w pliku „index.php”. Natomiast jeśli hasła się zgadzają zostaje przygotowane zapytanie UPDATE dla bazy danych. Wartości 
podane przez użytkownika w formularzu oraz id ze zmiennej globalnej $_SESSION[‘iduzytkownika’] ustawiane są jako parametr 
tego zapytania za pomocą funkcji bind_param.</br>
<br><i>Zakładka „Usuń konto”</i> jest operacją 204 w pliku „index.php”, która wyświetla dane aktualnie zalogowanego 
użytkownika z tabeli użytkownicy, komunikat proszący o potwierdzenie działania oraz przycisk „USUŃ” odsyłający do operacji 
204 w „operacjeDB.php”, usuwającej za pomocą zapytania DELETE użytkownika o id ze zmiennej globalnej 
$_SESSION[‘iduzytkownika’] z tabeli uzytkownicy.</br>

<br><b>Zakładki parametrów:</b>
<br>Wszystkie cztery zakładki parametrów: Tętno, Ciśnienie, Saturacja, Cukier zostały stworzone analogicznie. Zawierają 
one listę operacji dotyczących danego parametru: wyświetlanie rekordów, dodawanie i usuwanie pomiarów. Operacje dla tętna 
zaczynają się od cyfry 3, ciśnienia – 4, saturacji – 5, a cukru – 6, dalej oznaczonej literą x.</br>
<br><i>Zakładka „Wyświetl dane”</i> odsyła do operacji x01 w pliku „index.php”. Wyświetla ona komunikat z normą dla danego 
parametru, przycisk „Wyszukaj” odsyłający do operacji x011, przyciski nawigujące tabelą „Poprzednie” i „Następne” oraz 
zawartość tabeli konkretnego parametru w bazie danych. Na stronie wyświetlane jest 30 rekordów, poprzez ograniczenie 
zapytania SELECT w postaci zmiennej $offset, z możliwością przejścia do następnej strony lub cofania się.
<br>Operacja x011 wyświetla formularz z polami do wprowadzenia daty i/lub minimalnej wartości pomiaru jakie użytkownik 
chce wyszukać oraz przekierowuje do operacji x012 w „index.php”, która za pomocą zapytania SELECT wyświetla rekordy od 
podanej daty lub od wprowadzonej minimalnej wartości pomiaru.</br>
<br><i>Zakładka „Dodaj pomiar”</i> to operacja x02 w pliku „index.php”. Dołączony zostaje formularz z polami daty, godziny 
i wartości pomiaru oraz przyciskiem „Zapisz”. Przesłanie formularz inicjuje operację x02 w „operacjeDB.php”, która za 
pomocą zapytania INSERT dodaje rekord z wprowadzonymi w formularzu danymi do odpowiedniej tabeli w bazie danych.</br>
<br><i>Zakładka „Usuń pomiar”</i> odpowiada operacji x03 w „index.php”. Wyświetla ona zawartość tabeli konkretnego 
parametru w bazie danych z dodatkową akcją „USUŃ”. Przycisk ten odwołuje się do operacji x03 w pliku „operacjeDB.php”, 
która za pomocą zapytania DELETE usuwa rekord o id przesłanym podczas aktywowania przycisku.</br>
<br>
</div>