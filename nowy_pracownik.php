<?php
session_start();
include("pracownik.php")
?>

<html>
    <head>
    <title>Nowy pracownik</title>
<style>
a:link, a:visited {
  color: black;
}
</style>
    </head>
    <body>
    <h2>Dodaj nowego pracownika</h2>
    <form action="pracownik.php" method="post">
    Imię: <input type="text" name="imie" required><br>
    <br>
    Nazwisko: <input type="text" name="nazwisko" required><br>
    <br>
        <label><b>Wybierz specjalność pracownika:</b></label>
        <br>
        <?php
              for ($ri = 0; $ri < $numrows; $ri++) {
                $specjalnosc = pg_fetch_array($spis_spec, $ri)["nazwa"];
                echo $specjalnosc. ":". "<input type='checkbox' name='spec[]' value=".$specjalnosc. "><br>";
              }
        ?>
        </br>
        <br/>
        <b>Jeśli lista jest pusta to znaczy, że w bazie nie ma jeszcze żadnej specjalności. W takim wypadku musisz ją najpierw dodać.<br>
        W tym celu</b>
        <a href="nowa_spec.php">kliknij tutaj.</a>
        </br>
        <br/>
    <input type=submit value="Dodaj" name="submit">
    <br>
    </br>
    </form>
    </body>
    Jeśli na liście nie ma szukanej przez Ciebie specjalności, to musisz ją utworzyć:
    <a href="nowa_spec.php">Kliknij tutaj</a>
    </br>
    <br/>
    <form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form> <br>
</html>
    