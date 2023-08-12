<?php
session_start();

echo "<b style='color:red'>Musisz wybrać inną datę. Pracownik, który wykonuje wybrane przez Ciebie zadania, ma już w tym dniu zaplanowane  inne zadanie.</b>";
echo "<br>";
echo "<br>";
echo "<form action = 'zmiana_daty.php'> <input type = 'submit' value = 'Wybierz datę jeszcze raz' style='background-color: #5F9EA0;'> </form> <br>";
?>