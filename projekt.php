<?php
session_start();
?>
<html>
<head>
<title>Projekt</title>
<meta charset="utf-8">
</head>
<body>

<?php

$nazwa = $_POST["nazwa"];
$kwatera = $_POST["kwatera"];
// usuwam spacje i niepotrzebne znaki
$modified_nazwa = str_replace(" ", "_", $nazwa);

$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");
if (!$link) {
  print("Nie udało się połączyć z bazą danych.");
  exit;
}

// sprawdzam, czy projekt o tej nazwie jest już w bazie
$result = pg_query($link, "SELECT id_projektu FROM Projekty WHERE nazwa = '$modified_nazwa'");

if (pg_num_rows($result) > 0) {
  // projekt już istnieje
  echo "<b><font color='red'>Projekt o tej nazwie już istnieje w bazie! Wprowadź inną nazwę.</b></font>";
  echo '<br>';
  echo '<br>';
  echo '<form action = "nowy_projekt.php"> <input type = "submit" value = "Utwórz projekt jeszcze raz" style="background-color: #5F9EA0;"> </form>';
  echo '<form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form>';
}else {
// nazwa jest ok
// lista kwater do wyświetlania dla użytkownika
$spis_kwater = pg_query($link, "SELECT Nazwa FROM Kwatera");
$numrows1 = pg_numrows($spis_kwater);

if(isset($_POST['submit'])){
      $resk = pg_query_params($link, "SELECT id_kwatery FROM Kwatera WHERE nazwa= $1", array($kwatera));
      $rowk = pg_fetch_assoc($resk);
      $kwatera_id = $rowk['id_kwatery'];

      $wynik = pg_query($link, "INSERT INTO Projekty (Id_kwatery, Nazwa) VALUES ('" .
                        pg_escape_string($kwatera_id) .
                        "','" .pg_escape_string($modified_nazwa) ."')"); 

      if ($wynik) {
        echo "Nowy projekt został utworzony pomyślnie.";
      }
      else {
        echo "Nie udało się!<br>";
        echo pg_last_error($link) . "<br>";
      }
      echo '<br>';
      echo '<form action = "nowy_projekt.php"> <input type = "submit" value = "Utwórz kolejny projekt" style="background-color: #5F9EA0;"> </form>';
      echo '<form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form>';
      echo '<form action = "nowe_zadanie.php"> <input type = "submit" value = "Wróć do tworzenia nowego zadania" style="background-color: #5F9EA0;"> </form>';
}
}
?>
</br>
</br>
</body>
</html>