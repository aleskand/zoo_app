<?php
session_start();
?>

<html>
    <head>
    <title>Nowa lokalizacja</title>
    </head>
    <body>
    <h2>Dodaj nową lokalizację</h2>
    <form action="lokalizacja.php" method="post">
    Adres: <input type="text" name="adres" required><br>
    <br>
    <input type=submit value="Dodaj">
    </form>
    <form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form> <br>
</html>

