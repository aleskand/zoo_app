<?php
session_start();

echo "<b><font color='red'>Wybrałeś dzień, który już był! Wybiersz proszę poprawną nową datę.</b></font>";
    echo "<br>";
    echo "<br>";
    echo "<form action = 'zmiana_daty.php'> <input type = 'submit' value = 'Wybierz datę jeszcze raz' style='background-color: #5F9EA0;'> </form> <br>";
?>