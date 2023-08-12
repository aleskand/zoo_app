<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
.button {
  background-color: #A9CCE3; 
  border: none;
  color: black;
  cursor: pointer;
}
a:link, a:visited {
  color: black;
}
</style>
</head>
<body style="background-color: #F0F8FF;">
<h1 align="center">Cześć, <?=$_SESSION['user']?>!</h1>
<h1 align="center">Witaj na stronie ogrodu botanicznego dla pracowników</h1>
<br/>
<?php

$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");

if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

$imie = $_SESSION['user'];
$ID_pracownika0 = pg_query_params($link, "select id_pracownika from Pracownik WHERE imie =$1", array($imie));
$ID_pracownika1 = pg_fetch_array($ID_pracownika0);
$ID_pracownika = $ID_pracownika1["id_pracownika"];

$wynik = pg_query_params($link,
                         "SELECT ID_zadania, DataZ, ID_projektu, ID_specjalnosci 
                          FROM Zadania
                          WHERE ID_pracownika = $1",
                          array($ID_pracownika));
$ile = pg_numrows($wynik);
?>
<h2 align="center">Oto lista twoich zadań:</h2>
<?php
if ($ile == 0) {
  echo "<center><strong style='color:green'>Laba! nie masz żadnych zadań do wykonania :)</strong></center>";
} else{
  ?>
  <table border="1" align=center>
  <tr>
  <th>Id zadania</th>
  <th>Data</th>
  <th>Typ</th>
  <th>Nazwa projektu</th>
  <th>Nazwa kwatery</th>
  <th>Nazwa lokalizacji</th>
  </tr>
  <?php
  // wybieranie z bazy tak aby się ładnie wyświetlało
  for ($ri = 0; $ri < $ile; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($wynik, $ri);
    // nazwa specjalnosci
    $spec0 = pg_query_params($link, "Select nazwa from Specjalnosci Where id_specjalnosci = $1", array($row["id_specjalnosci"]));
    $spec1 = pg_fetch_assoc($spec0);
    $spec = $spec1["nazwa"];
    // nazwa projektu
    $projekt0 = pg_query_params($link, "Select nazwa from Projekty Where id_projektu = $1", array($row["id_projektu"]));
    $projekt1 = pg_fetch_array($projekt0);
    $proj = $projekt1['nazwa'];
    // nazwa kwatery
    $id_kwat0 = pg_query_params($link, "Select id_kwatery from Projekty Where id_projektu = $1", array($row["id_projektu"]));
    $id_kwat1 = pg_fetch_array($id_kwat0);
    $id_kwatera = $id_kwat1['id_kwatery'];
    $kwat0 = pg_query_params($link, "Select nazwa from Kwatera Where id_kwatery = $1", array($id_kwatera));
    $kwat1 = pg_fetch_array($kwat0);
    $kwatera = $kwat1['nazwa'];
    // nazwa lokalizacji
    $id_lok0 = pg_query_params($link, "Select id_lokalizacji from Kwatera Where id_kwatery = $1", array($id_kwatera));
    $id_lok1 = pg_fetch_array($id_lok0);
    $id_lok = $id_lok1['id_lokalizacji'];
    $lok0 = pg_query_params($link, "Select adres from Lokalizacja Where id_lokalizacji = $1", array($id_lok));
    $lok1 = pg_fetch_array($lok0);
    $lok = $lok1['adres'];
    echo " <td>" . $row["id_zadania"] . "</td>
  <td>" . $row["dataz"] . "</td><td>" . $spec . "</td><td>" . $proj . "</td><td>" . $kwatera . "</td><td>" . $lok . "</td>
  </tr>
  ";
  }
  echo "<table/>";
}
pg_close($link);
?>
</body>
<br>
<center>
<a href="logout.php"><b>Wyloguj się</b></a>
</br>
<br/>
<img src="glowna.JPG" width="1000" height="500"></center>
</html>