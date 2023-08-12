<?php
session_start();

echo "<b><font color='red'>Wybrałeś dzień, który już był! Wybiersz proszę poprawną datę zaplanowanego zadania.</b></font>";
    echo "<br>";
    echo "<br>";
    echo "<form action = 'nowe_zadanie.php'> <input type = 'submit' value = 'Dodaj zadanie jeszcze raz' style='background-color: #5F9EA0;'> </form> <br>";
?>