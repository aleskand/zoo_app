<?php
session_start();
?>
<html>
<head>
<title>Specjalność</title>
<meta charset="utf-8">
</head>
<body>

<?php

$nazwa = $_POST["nazwa"];
// usuwam spacje i niepotrzebne znaki
$modified_nazwa = str_replace(" ", "_", $nazwa);

$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");
if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

// sprawdzam, czy specjalność o tej nazwie jest już w bazie
$result = pg_query($link, "SELECT id_specjalnosci FROM Specjalnosci WHERE nazwa = '$modified_nazwa'");

if (pg_num_rows($result) > 0) {
  // specjalność już istnieje
  echo "<b><font color='red'>Specjalność o tej nazwie już istnieje w bazie! Wprowadź inną nazwę.</b></font>";
}else {
  // nazwa jest ok
  $wynik = pg_query($link,
                    "INSERT INTO Specjalnosci (Nazwa) VALUES ('" . 
                    pg_escape_string($modified_nazwa) ."')"); 

  if ($wynik) {
    echo "<b><font color='green'>Nowe specjalność została poprawnie dodana do bazy.</b></font>";
  }
  else {
    echo "Nie udało się!<br>";
    echo pg_last_error($link) . "<br>";
  }
}
?>
</br>
</br>
<form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form>
lub
<br>
<br>
<form action = "nowa_spec.php"> <input type = "submit" value = "Dodaj kolejną specjalność" style="background-color: #5F9EA0;"> </form> <br>
</body>
</html>