<?php

session_start();
?>

<html>
    <head>
    <title>Nowa specjalność</title>
    </head>
    <body>
    <h2>Dodaj nową specjalność</h2>
    <form action="specjalnosc.php" method="post">
    Nazwa: <input type="text" name="nazwa" required><br>
    <br>
    <input type=submit value="Dodaj">
    </form>
    </body>
    <form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form> <br>
</html>

