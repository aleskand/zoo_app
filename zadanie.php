<html>
<head>
<title>Nowe zadanie</title>
<meta charset="utf-8">
</head>
<body>

<?php
session_start();

// połączenie z bazą
$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");
if (!$link) {
  print("Błąd połączenia z bazą danych.");
  exit;
}
// lista specjalności zadań do wyświetlania dla użytkownika
$spis_specjalnosci = pg_query($link, "SELECT Nazwa FROM Specjalnosci");
$numrows = pg_numrows($spis_specjalnosci);

// przekazywane zmienne
$dataz = $_POST["data"];
$specz = $_POST["spec"];

if(isset($_POST['submit'])){
  // sprawdzam poprawność wprowadzonej daty - nie można dodawać zadań w przeszłosci
  $now = strtotime(date('Y-m-d'));
  if(strtotime($dataz) < $now) {
  header("Location: https://students.mimuw.edu.pl/~as420561/blad_daty.php?");
  }

  // pobieranie ID specjalnosci
  $res0 = pg_query_params($link, "SELECT ID_specjalnosci FROM Specjalnosci WHERE nazwa= $1", array($specz));
  $row0 = pg_fetch_assoc($res0);
  $id_s = $row0['id_specjalnosci'];

  // pobieranie ID kwatery
  $resk = pg_query_params($link, "SELECT id_kwatery FROM Kwatera WHERE nazwa= $1", array($kwateraz));
  $rowk = pg_fetch_assoc($resk);
  $id_kwatery = $rowk['id_kwatery'];

  //zmienne, które przekazuję dalej
  $_SESSION['data'] = $dataz;
  $_SESSION['spec'] = $id_s;

  // szukam listy dostępnych w danym dniu projektów
  // lista wszystkich projeków
  $spis_projektow = pg_query($link, "SELECT Id_projektu FROM Projekty");
  $lista_idprojektu_data = pg_query_params($link, "Select id_projektu from Zadania Where dataz = $1", array($dataz));
  $numrowspro = pg_numrows($lista_idprojektu_data);
  if ($numrowspro > 0){
    // jeśli jest większy od zera to musimy zmodyfikować naszą listę.
      $lista_id_projekt = array_diff($spis_projektow, $lista_idprojektu_data);
      $numrowsprojekt = pg_numrows($lista_id_projekt);
  }else{
      //jeśli == 0 to znaczy, że żaden projekt nie ma przypisanego zadania tego dnia, mamy pełną pulę wyboru
      $lista_id_projekt = $spis_projektow;
      $numrowsprojekt = pg_numrows($lista_id_projekt);
  }

  //////////////////////////////////////////////////////////
  // Wybieranie poprawnego pracownika - dostępnego w danym dniu oraz o odpowiedniej specjalności
  $lista_idp = pg_query_params($link, "Select id_pracownika from Zespol Where id_specjalnosci = $1", array($id_s));
  $lista_id_data = pg_query_params($link, "Select id_pracownika from Zadania Where dataz = $1", array($dataz));
  $numrowsda = pg_numrows($lista_id_data);
  echo "<br>";
  if ($numrowsda > 0){
    //jeśli == 0 to znaczy, że żaden pracownik nie ma przypisanego zadania tego dnia, mamy pełną pulę wyboru
    // jeśli jest większy od zera to musimy zmodyfikować naszą listę.
      $lista_id = array_diff($lista_idp, $lista_id_data);
      $numrows2 = pg_numrows($lista_id);
  }else{
      $lista_id = $lista_idp;
      $numrows2 = pg_numrows($lista_id);
  }
  echo "Teraz wybierz pracownika, który będzie wykonywał zadanie oraz projekt, pod który będzie podlegać tworzone zadanie: <br>";
  echo "<br>";
  echo "<b>Jeśli na lista jest pusta, to znaczy, że w bazie nie ma żadnego pracownika tej specjalności <br> lub wszyscy pracownicy mają już tego dnia przydzielone zadanie.</b> <br>";
  echo "<br>";
  echo '<form method="POST">';
  echo "<label><b>Wybierz pracownika: </b></label>";
  echo "<select name='pracownik' required>";
  echo '<option value="" selected disabled hidden></option>';
            for ($ri = 0; $ri < $numrows2; $ri++) {
              // potrzebujemy imienia i nazwiska pracownika
              $idp = pg_fetch_array($lista_id, $ri)["id_pracownika"];
              $r = pg_query_params($link, "SELECT imie, nazwisko FROM Pracownik WHERE id_pracownika= $1", array($idp));
              $rf = pg_fetch_assoc($r);
              $imie = $rf['imie'];
              $nazwisko = $rf['nazwisko'];
              $pracownik = $imie. ' ' . $nazwisko;
              echo "<option value='" . $pracownik . "'>" . $pracownik . "</option>";
            }
echo "</select>";
echo "</br>";
if ($numrows2 == 0){
  echo "<b style='color:red'> Brak dostępnych pracowników! Zmień datę zadania, specjalność lub dodaj do bazy nowego pracownika.</b>";}
echo "<br/>";
echo "<br/>";
////////////// PROJEKT
echo "<b>Jeśli lista jest pusta, to znaczy, że w bazie nie ma żadnego projektu dostępnego w tym dniu.</b> <br>";
echo "<b>Zmień datę zadania lub dodaj do bazy nowy projekt.</b> <br>";
  echo "<br>";
  if ($numrowsprojekt == 0){
    echo "<b style='color:red'> Brak dostępnych projektów! Zmień datę zadania lub dodaj do bazy nowy projekt.</b>";}
  echo "</br>";
  echo "<label><b>Wybierz nazwę projektu: </b></label>";
  echo "<select name='projekt' required>";
  echo '<option value="" selected disabled hidden></option>';
            for ($ri = 0; $ri < $numrowsprojekt; $ri++) {
              $ip = pg_fetch_array($lista_id_projekt, $ri)["id_projektu"];
              $res = pg_query_params($link, "SELECT Nazwa FROM Projekty WHERE id_projektu= $1", array($ip));
              $row = pg_fetch_array($res);
              $projekt = $row[0];
              echo "<option value='" . $projekt . "'>" . $projekt . "</option>";
            }
echo "</select>";
echo "</br>";
echo "<br/>";
echo '<input type=submit value="Dodaj" name="submit2"><br>';
echo '</form>';
echo "<br>";
echo "<form action = 'nowe_zadanie.php'> <input type = 'submit' value = 'Wróć do tworzenia zadania.' style='background-color: #5F9EA0;'> </form> <br>";
}

if(isset($_POST['submit2'])){
  // wszystkie dane potrzebne do wpisania do bazy
  $dataz = $_SESSION['data'];
  $id_sp = $_SESSION['spec'];
  $nazwa_prac = $_POST["pracownik"];
  $id_zadania = $_POST["id_z"];
  $imie = explode(" ", $nazwa_prac)[0];
  $nazwa_proj = $_POST['projekt'];

  // pobieranie ID pracownika
  $res1 = pg_query_params($link, "SELECT ID_pracownika FROM Pracownik WHERE imie= $1", array($imie));
  $row1 = pg_fetch_assoc($res1);
  $id_p = $row1['id_pracownika'];

    // pobieranie ID projektu
    $res2 = pg_query_params($link, "SELECT ID_projektu FROM Projekty WHERE nazwa= $1", array($nazwa_proj));
    $row2 = pg_fetch_assoc($res2);
    $id_projekt = $row2['id_projektu'];

  // mamy wszystkie potrzebne dane, wstawiamy je do bazy danych  
  $wynik = pg_query_params($link,
                    "INSERT INTO Zadania (DataZ, Id_pracownika, Id_projektu, id_specjalnosci) VALUES ($1, $2, $3, $4)", array($dataz, $id_p, $id_projekt, $id_sp));
  if ($wynik) {
    echo "Nowe zadanie zostało poprawnie dodane do bazy.<br>";
    echo "</br>";
    echo "<form action = 'zalogowany.php'> <input type = 'submit' value = 'Wróć na stronę główną' style='background-color: #5F9EA0;'> </form> <br>";
    echo "Lub dodaj kolejne zadanie do bazy: ";
    echo "<br>";
    echo "<form action = 'nowe_zadanie.php'> <input type = 'submit' value = 'Dodaj kolejne zadanie' style='background-color: #5F9EA0;'> </form> <br>";
    echo "<br>";
  }
  else {
    echo "Nie udało się utworzyć zadania! Spróbuj ponownie.<br>";
    echo "<br>";
    echo pg_last_error($link) . "<br>";
    echo "<form action = 'zalogowany.php'> <input type = 'submit' value = 'Wróć na stronę główną' style='background-color: #5F9EA0;'> </form> <br>";
    echo "Lub dodaj kolejne zadanie do bazy: ";
    echo "<form action = 'nowe_zadanie.php'> <input type = 'submit' value = 'Dodaj kolejne zadanie' style='background-color: #5F9EA0;'> </form> <br>";
    echo "<br>";
  }
}
?>
</body>
</html>