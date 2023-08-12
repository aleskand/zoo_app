<html>
<head>
<title>Lista projektów</title>
</head>
<body bgcolor="white">

<?php
session_start();
$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");

if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

$result = pg_query($link, "select * from Projekty");
$numrows = pg_numrows($result);
?>

<h2 align="center">Lista projektów i zadań</h2>

<center><?php
  // wyświetlanie projektów i zadań
  for ($ri = 0; $ri < $numrows; $ri++) {
    $row = pg_fetch_array($result, $ri);
    $result2 = pg_query_params($link, "Select id_zadania, dataz, id_pracownika, id_specjalnosci from Zadania Where id_projektu = $1", array($row["id_projektu"]));
    $numrows2 = pg_numrows($result2);
    echo "<tr>\n";
    echo "<br>";
    echo "<b>". $row["id_projektu"]. ". " .$row["nazwa"]."</b>";
    echo "<br>";
    if ($numrows2 == 0){
      echo "Brak zadań w tym projekcie.";
      echo "<br>";
    } else{
      echo "<br>";
      echo "<table border='1'>";
      echo "<tr>";
      echo "<th>Id zadania</th>";
      echo "<th>Data zadania</th>";
      echo "<th>Nazwa pracownika</th>";
      echo "<th>Specjalność</th>";
      echo "</tr>";
      for ($si = 0; $si < $numrows2; $si++) {
      $row2 = pg_fetch_array($result2, $si);
      $r = pg_query_params($link, "SELECT imie, nazwisko FROM Pracownik WHERE id_pracownika= $1", array($row2["id_pracownika"]));
        $rf = pg_fetch_assoc($r);
        $imie = $rf['imie'];
        $nazwisko = $rf['nazwisko'];
        $pracownik = $imie. ' ' . $nazwisko;
      $spec0 = pg_query_params($link, "Select nazwa from Specjalnosci Where id_specjalnosci = $1", array($row2["id_specjalnosci"]));
      $spec1 = pg_fetch_assoc($spec0);
      $spec = $spec1["nazwa"];
      echo "<tr>\n";
      echo " <td>" . $row2["id_zadania"] . "</td> <td>" . $row2["dataz"] . "</td><td>" . $pracownik . "</td><td>" . $spec . "</td>";    
      }
      echo "</table>";
    "</td>
    </tr>";
    echo "<br>";
  }
}
echo "<br>";
echo "<br>";
pg_close($link);
?>
<form action = "zalogowany.php"><input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;" align="center"> </form> <br></center>
</body>
</html>