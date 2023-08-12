<?php
session_start();

echo "<b style='color:red'>Musisz wybrać inną datę. Projekt, do którego przynależy wybrane przez Ciebie zadania, ma już w tym dniu zaplanowane zadanie.</b>";
echo "<br>";
echo "<br>";
echo "<form action = 'zmiana_daty.php'> <input type = 'submit' value = 'Wybierz datę jeszcze raz' style='background-color: #5F9EA0;'> </form> <br>";
?>