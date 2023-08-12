<html>
<head>
<title>Lista specjalności</title>
</head>
<body bgcolor="white">

<?php
session_start();
$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");

if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

$result = pg_query($link, "select * from Specjalnosci");
$numrows = pg_numrows($result);
?>

<h2 align="center">Lista specjalności</h2>

<table border="1" align=center>
<tr>
 <th>Id</th>
 <th>Specjalność</th>
</tr>
<?php

  for ($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>" . $row["id_specjalnosci"] . "</td>
<td>" . $row["nazwa"] . "</td>
</tr>
";
   }
  pg_close($link);
?>
</table>
</br>
<br/>
<center><form action = "zalogowany.php"><input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;" align="center"> </form> <br></center>
</body>
</html>