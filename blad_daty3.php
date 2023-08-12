<?php
session_start();

echo "<b style='color:red'>Nowo wybrana data jest taka sama jak stara. Wybierz nową datę jeszcze raz.</b>";
echo "<br>";
echo "<br>";
echo "<form action = 'zmiana_daty.php'> <input type = 'submit' value = 'Wybierz datę jeszcze raz' style='background-color: #5F9EA0;'> </form> <br>";
?>