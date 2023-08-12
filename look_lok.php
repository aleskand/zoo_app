<html>
<head>
<title>Lista lokalizacji</title>
</head>
<body bgcolor="white">

<?php
session_start();
$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");

if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

$result = pg_query($link, "select * from Lokalizacja");
$numrows = pg_numrows($result);
?>

<h2 align="center">Lista lokalizacji oraz kwater</h2>

<center><?php
  // wyświetlanie lokalizacji i kwater
  for ($ri = 0; $ri < $numrows; $ri++) {
    $row = pg_fetch_array($result, $ri);
    $result2 = pg_query_params($link, "Select id_kwatery, nazwa from Kwatera Where id_lokalizacji = $1", array($row["id_lokalizacji"]));
    $numrows2 = pg_numrows($result2);
    echo "<tr>\n";
    echo "<br>";
    echo "<b>". $row["id_lokalizacji"]. ". " .$row["adres"]."</b>";
    echo "<br>";
    if ($numrows2 == 0){
      echo "Brak kwater w danej lokalizacji.";
      echo "<br>";
    } else{
      echo "<br>";
      echo "<table border='1'>";
      echo "<tr>";
      echo "<th>Id kwatery</th>";
      echo "<th>Nazwa</th>";
      echo "</tr>";
      for ($si = 0; $si < $numrows2; $si++) {
      $row2 = pg_fetch_array($result2, $si);
      echo "<tr>\n";
      echo " <td>" . $row2["id_kwatery"] . "</td> <td>" . $row2["nazwa"] . "</td>";    
      }
      echo "</table>";
    "</td>
    </tr>";
    echo "<br>";
  }
}
echo "<br>";
pg_close($link);
?>
<form action = "zalogowany.php"><input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;" align="center"> </form> <br></center>
</body>
</html>