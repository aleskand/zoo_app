<?php
session_start();
include("zmiana.php")
?>

<html>
    <head>
    <title>Zmień datę zadania</title>
<style>
a:link, a:visited {
  color: black;
}
</style>
    </head>
    <body>
    <h2>Zmień datę zadania</h2>
        <label><b>Wybierz zadanie, któremu chcesz zmienić datę:</b></label>
        <br>
        Możesz zmienić na raz datę tylko w jednym zadaniu. Jeśli chcesz zmienić kilka dat, zrób to proszę w osobnych krokach.
        <form action="zmiana.php" method="post">
        <br>
        <?php
        if ($numrows == 0){
          "<b style='color:red'>Brak zadań w bazie!.</b>";
          echo "</tr>";
        }else{
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Id zadania</th>";
        echo "<th>Data zadania</th>";
        echo "<th>Nazwa pracownika</th>";
        echo "<th>Specjalność</th>";
        echo "<th>Projekt</th>";
        echo "<th>Wybierz</th>";
        echo "</tr>";
              for ($ri = 0; $ri < $numrows; $ri++) {
                $id_zad = pg_fetch_array($result, $ri)["id_zadania"];
                $data_zadania = pg_fetch_array($result, $ri)["dataz"];
                $id_pracownika = pg_fetch_array($result, $ri)["id_pracownika"];
                $id_specjalnosci = pg_fetch_array($result, $ri)["id_specjalnosci"];
                $id_projektu = pg_fetch_array($result, $ri)["id_projektu"];
                // znajdź imię i nazwisko
                $r = pg_query_params($link, "SELECT imie, nazwisko FROM Pracownik WHERE id_pracownika= $1", array($id_pracownika));
                $rf = pg_fetch_assoc($r);
                $imie = $rf['imie'];
                $nazwisko = $rf['nazwisko'];
                $pracownik = $imie. ' ' . $nazwisko;
                // znajdź specjalność
                $spec0 = pg_query_params($link, "Select nazwa from Specjalnosci Where id_specjalnosci = $1", array($id_specjalnosci));
                $spec1 = pg_fetch_assoc($spec0);
                $spec = $spec1["nazwa"];
                // znajdź projekt
                $pro0 = pg_query_params($link, "Select nazwa from Projekty Where id_projektu = $1", array($id_projektu));
                $pro1 = pg_fetch_assoc($pro0);
                $proj = $pro1["nazwa"];
                echo "<tr>\n";
                echo " <td>" . $id_zad . "</td> <td>" . $data_zadania . "</td><td>" . $pracownik . "</td><td>" . $spec . "</td><td>" . $proj . "</td>";
                echo "<td>" . '<input type="radio" name="zadanie" value=' . $id_zad . ' />' . "</td>";
              }
        echo "</table>";
        }
        ?>
        </br>
        <br/>
    <input type=submit value="Przejdź dalej, aby wybrać nową datę" name="submit">
    </form>
    <br>
        <b>Jeśli lista jest pusta to znaczy, że w bazie nie ma jeszcze żadnych zadań.<br>
        Aby dodać nowe zadanie</b>
        <a href="nowe_zadanie.php">kliknij tutaj.</a>
    </body>
    </br>
    <br/>
    <form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form> <br>
</html>
    