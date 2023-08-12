<?php
    session_start();
    $link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");
    if (!$link) {
        print("Błąd połączenia z bazą danych.");
        exit;
      }
  

    $spis_adresow = pg_query($link, "SELECT Adres FROM Lokalizacja");
    $numrows = pg_numrows($spis_adresow);

    if(isset($_POST['submit']))
    {
        $adr = $_POST['adres'];
        $nazwa = $_POST["nazwa"];
        // usuwam spacje i niepotrzebne znaki
        $modified_nazwa = str_replace(" ", "_", $nazwa);
        $modified_nazwa2 = pg_escape_string($link, $modified_nazwa);

        // sprawdzam, czy lokalizacja o tej nazwie jest już w bazie
        $result = pg_query($link, "SELECT id_kwatery FROM Kwatera WHERE Nazwa = '$modified_nazwa2'");

        if (pg_num_rows($result) > 0) {
          echo "<b><font color='red'>Kwatera o podanej nazwie już istnieje w bazie! Wprowadź inną nazwę.</b></font>";
        } else {
          // znajdź ID lokalizacji
          $res = pg_query_params($link, "SELECT ID_lokalizacji FROM Lokalizacja WHERE Adres= $1", array($adr));
          $row = pg_fetch_assoc($res);
          $id = $row['id_lokalizacji'];         
          // wstaw nazwę kwatery
          $wynik = pg_query_params($link, "INSERT INTO KWATERA (ID_lokalizacji, Nazwa) VALUES ($1, $2)", array($id, $modified_nazwa2)); 

        if ($wynik) {
          echo "<b><font color='green'>Nowa kwatera została poprawnie dodana do bazy. Dodaj kolejną lub wróć na stronę główną - przycisk na dole.</b></font>";
        } else {
          echo "<b><font color='red'></font>Coś poszło nie tak! Spróbuj ponownie dodać kwaterę.</b></font><br>";
          echo pg_last_error($link) . "<br>";
        }
        }
    }
?>
  
  
<!DOCTYPE html>
<html lang="en">
<head>
<title>Nowa kwatera</title>
<style>
a:link, a:visited {
  color: black;
}
</style>  
</head>
<body>
<h2>Dodaj nową kwaterę</h2>
    <form method="POST">
        <label>Wpisz nazwę kwatery:</label>
        <input type="text" name="nazwa" required><br>
        <br>
        <label>Wybierz lokalizację kwatery:</label>
        <select name="adres" required>
        <option value="" selected disabled hidden></option>
            <?php
              for ($ri = 0; $ri < $numrows; $ri++) {
                $adres = pg_fetch_array($spis_adresow, $ri)["adres"];
                echo "<option value='" . $adres . "'>" . $adres . "</option>";
              }
            ?>
        </select>
        </br>
        <br/>
        <b>Jeśli lista się nie rozwija to znaczy, że w bazie nie ma jeszcze żadnej lokalizacji. W takim wypadku musisz ją najpierw dodać.<br>
        W tym celu</b>
        <a href="nowa_lok.php">kliknij tutaj.</a>
        </br>
        <br/>
        <input type="submit" value="Dodaj" name="submit">
    </form>
    <br>
</body>
</br>
<form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form> <br>
</html>