<?php
session_start();
?>
<html>
<head>
<title>Nowa lokalizacja</title>
<meta charset="utf-8">
</head>
<body>

<?php

$adres = $_POST["adres"];
// usuwam spacje w nazwie
$modified_adres = str_replace(" ", "_", $adres);

$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");
if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

// sprawdzam, czy lokalizacja o tej nazwie jest już w bazie
$result = pg_query($link, "SELECT id_lokalizacji FROM Lokalizacja WHERE Adres = '$modified_adres'");

if (pg_num_rows($result) > 0) {
  echo "<b><font color='red'>Lokalizacja o podanej nazwie już istnieje w bazie! Wprowadź inną nazwę.</b>";
} else {
    // wstawiawiam do bazy
  $wynik = pg_query($link, "INSERT INTO LOKALIZACJA (Adres) VALUES ('" . 
  pg_escape_string($modified_adres) ."')"); 

  if ($wynik) {
  echo "<b><font color='green'>Nowa lokalizacja została poprawnie dodana do bazy.</b>";
  }
  else {
  echo "Nie udało się!<br>";
  echo pg_last_error($link) . "<br>";
  }
}

?>
</br>
</br>
<form action = "nowa_lok.php"> <input type = "submit" value = "Dodaj kolejną lokalizację" style="background-color: #5F9EA0;"> </form> <br>
<form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form> <br>
</body>
</html>