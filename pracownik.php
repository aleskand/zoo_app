<html>
<head>
<title>Nowy pracownik</title>
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
// lista specjalności do wyświetlania dla użytkownika
$spis_spec = pg_query($link, "SELECT Nazwa FROM Specjalnosci");
$numrows = pg_numrows($spis_spec);

// przekazywane zmienne
$imie = $_POST["imie"];
$nazwisko = $_POST["nazwisko"];
$spis_specjalnosci = $_POST["spec"];


// wstawianie do bazy danych
if(isset($_POST['submit'])){
  // sprawdzam, czy pracownik o tym imieniu i nazwisku jest już w bazie
  $result = pg_query($link, "SELECT id_pracownika FROM Pracownik WHERE imie = '$imie' and nazwisko= '$nazwisko'");

  if (pg_num_rows($result) > 0) {
    echo "<b><font color='red'>Pracownik o tym imieniu i nazwisku już istnieje w bazie! Wprowadź inne imie.</b></font>";
    echo "</br>";
    echo "<br/>";
    echo "<form action = 'zalogowany.php'> <input type = 'submit' value = 'Wróć na stronę główną' style='background-color: #5F9EA0;'> </form> <br>";
    echo "Lub dodaj kolejnego pracownika do bazy: ";
    echo "</br>";
    echo "<br/>";
    echo "<form action = 'nowy_pracownik.php'> <input type = 'submit' value = 'Dodaj kolejnego pracownika' style='background-color: #5F9EA0;'> </form> <br>";
    echo "<br>";
  } else {

  // wstawianie imienia i nazwiska
  $wynik1 = pg_query($link,
                    "INSERT INTO PRACOWNIK (Imie, Nazwisko) VALUES ('" . 
                    pg_escape_string($imie) .
                    "','" . pg_escape_string($nazwisko) ."')");
  // pobieranie ID pracownika
  $res = pg_query_params($link, "SELECT ID_pracownika FROM Pracownik WHERE imie= $1", array($imie));
  $row = pg_fetch_assoc($res);
  $id_p = $row['id_pracownika'];
  // ile secjalnosci do dodania
  $num_spec = count($spis_specjalnosci);
  // wstawianie specjalnosci w pętli
  for ($ri = 0; $ri < $num_spec; $ri++) {
    //pobieranie ID specjalnosci
    $nazwa_spec = $spis_specjalnosci[$ri];
    $res2 = pg_query_params($link, "SELECT id_specjalnosci FROM Specjalnosci WHERE nazwa like '%' || $1 || '%'", array($nazwa_spec));
    $row2 = pg_fetch_assoc($res2);
    $id_s = $row2['id_specjalnosci'];
    $wynik = pg_query_params($link, "insert into Zespol (id_pracownika, id_specjalnosci) values ($1, $2)", array($id_p, $id_s)); 
  }
  if ($wynik) {
    echo "Nowy pracownik został poprawnie dodany do bazy.<br>";
    echo "</br>";
    echo "<form action = 'zalogowany.php'> <input type = 'submit' value = 'Wróć na stronę główną' style='background-color: #5F9EA0;'> </form> <br>";
    echo "Lub dodaj kolejnego pracownika do bazy: ";
    echo "<form action = 'nowy_pracownik.php'> <input type = 'submit' value = 'Dodaj kolejnego pracownika' style='background-color: #5F9EA0;'> </form> <br>";
    echo "<br>";
  }
  else {
    echo "Nie udało się!<br>";
    echo "<br>";
    echo pg_last_error($link) . "<br>";
    echo "<form action = 'zalogowany.php'> <input type = 'submit' value = 'Wróć na stronę główną' style='background-color: #5F9EA0;'> </form> <br>";
  }
}
}
?>
</body>
</html>