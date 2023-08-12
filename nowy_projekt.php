<?php
session_start();
include("projekt.php");
?>
<html>
    <head>
    <title>Nowe projekt</title>
    </head>
    <body>
    <h2>Dodaj nowy projekt</h2>
    
    <form action="projekt.php" method="post">
    Nazwa <input type="text" name="nazwa" required><br>
    <br>
    <label>Wybierz kwaterę, której będzie dotyczył projekt:</label>
        <select name="kwatera" required>
        <option value="" selected disabled hidden></option>
            <?php
              for ($ri = 0; $ri < $numrows1; $ri++) {
                $kwatera = pg_fetch_array($spis_kwater, $ri)["nazwa"];
                echo "<option value='" . $kwatera . "'>" . $kwatera . "</option>";
              }
            ?>
        </select>
        </br>
        <br/>
    <input type=submit value="Dodaj" name="submit">
    </form>
    </body>
    </br>
    <form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form>
</html>
    