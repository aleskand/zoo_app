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
.image-container {
        text-align: right;
}
</style>
</head>
<body style="background-color: #F0F8FF;">
<div style="clear:both;">
<img src="glowna.JPG" width="800" height="400" style="float:right;">
<h1 align="center">Cześć, <?=$_SESSION['user']?>!</h1>
<h1 align="center">Witaj w centrum zarządzania ogrodem botanicznym</h1>
<br/>
<b>Oto lista twoich możliwości: </b>
</br>
<br/>
<ul><li><button type = 'button', class="button"><a href="nowa_lok.php">Dodaj nową lokalizację</a></button></li></ul>
<ul><li><button type = 'button', class="button"><a href="nowa_kwatera.php">Dodaj nową kwaterę</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="nowy_pracownik.php">Dodaj nowego pracownika</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="nowa_spec.php">Dodaj nową specjalność</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="nowy_projekt.php">Dodaj nowy projekt</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="nowe_zadanie.php">Dodaj nowe zadanie</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="zmiana_daty.php">Zmień termin zadania</a></button></li></ul>
<br/>
<b>Wyświetl:</b>
</br>
<br/>
<ul><li><button type = 'button', class="button"><a href="look_lok.php">Listę lokalizacji i kwater</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="look_pracownik.php">Listę pracowników</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="look_spec.php">Listę specjalności</a></button></li></ul>
<ul><li><button type = 'button', class="button" ><a href="look_projekt.php">Listę projektów i zadań</a></button></li></ul>
<br/>
<b>Logowanie dla pracowników: </b><br>
<br>
Każdy pracownik ma domyśle hasło: "ogrod".<br>
Login pracownika to jego nr ID.
<br>
<br>
<a href="logout.php"><b>Wyloguj się</b></a>
</br>
<br/>
</div>
</body>
</html>