<html>
<head>
<title>Lista pracowników</title>
</head>
<body bgcolor="white">

<?php
session_start();
$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");

if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

$result = pg_query($link, "select * from Pracownik");
$numrows = pg_numrows($result);
?>

<h2 align="center">Lista pracowników i ich specjalności</h2>

<center><?php
  // wyświetlanie pracowników i ich specjalności
  for ($ri = 0; $ri < $numrows; $ri++) {
    $row = pg_fetch_array($result, $ri);
    $result2 = pg_query_params($link, "Select id_specjalnosci from Zespol Where id_pracownika = $1", array($row["id_pracownika"]));
    $numrows2 = pg_numrows($result2);
    echo "<tr>\n";
    echo "<br>";
    echo "<b>". $row["id_pracownika"]. ". " .$row["imie"]." ". $row["nazwisko"]."</b>";
    echo "<br>";
    if ($numrows2 == 0){
      echo "Ten pracownik nie ma żadnej super mocy :(";
      echo "<br>";
    } else{
      echo "<br>";
      echo "<table border='1'>";
      echo "<tr>";
      echo "<th>Super moc</th>";
      echo "</tr>";
      for ($si = 0; $si < $numrows2; $si++) {
        $row2 = pg_fetch_array($result2, $si);
        $id_spec = $row2["id_specjalnosci"];
        // dostajemy id specjalnosci, szukamy jej nazwy
        $res = pg_query_params($link, "SELECT nazwa FROM Specjalnosci WHERE id_specjalnosci= $1", array($id_spec));
        $row = pg_fetch_assoc($res);
        $nazwa = $row['nazwa'];
        echo "<tr>\n";
        echo "</td> <td>" . $nazwa . "</td>";    
      }
      echo "</table>";
    "</td>
    </tr>";
    echo "<br>";
  }
}
echo "<br>";
pg_close($link);
echo "<br>";
?>
<form action = "zalogowany.php"><input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;" align="center"> </form> <br></center>
</body>
</html>