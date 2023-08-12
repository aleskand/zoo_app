<?php
session_start();
include("zadanie.php")
?>
<html>
    <head>
    <title>Nowe zadanie</title>
    </head>
    <body>
    <h2>Dodaj nowe zadanie</h2>
    Upewnij się, że projekt, do którego chcesz dodać zadanie został wcześniej utworzony, jeśli nie to utwórz go teraz:<br> 
    <form action = "nowy_projekt.php"> <input type = "submit" value = "Stwórz projekt" style="background-color: #5F9EA0;"> </form>
    <b>Najpierw wybierz proszę datę i konkretny typ zadania. Dzięki temu wyświetlą się do wyboru tylko ci pracownicy, którzy umieją je poprawnie <br> 
    wykonać (mają daną specjalność)
    i są dostępni danego dnia.<br>  
    <br>
    W kolejym kroku będziesz też mógł wybrać projekt, który w danym dniu nie ma jeszcze żadnego zadania. Pamiętaj, że wybór projektu jest <br> 
    jednoznaczny z wyborem  przypisanej do niego kwatery.
    <br>
        
    <form action="zadanie.php" method="post">
    <br>
    Data: <input type="date" name="data" required><br>
    <br>
    UWAGA: Wybierz datę conajmniej dzisiejszą! Nie można dodawać zadań wstecz.<br>   
    </br>
        <label>Wybierz typ zadania:</label>
        <select name="spec" required>
        <option value="" selected disabled hidden></option>
            <?php
              for ($ri = 0; $ri < $numrows; $ri++) {
                $spec = pg_fetch_array($spis_specjalnosci, $ri)["nazwa"];
                echo "<option value='" . $spec . "'>" . $spec . "</option>";
              }
            ?>
        </select>
        </br>
        <br/>
    <input type=submit value="Dodaj" name="submit">
    </form>
    </body>
    </br>
    <form action = "zalogowany.php"> <input type = "submit" value = "Wróć na stronę główną" style="background-color: #5F9EA0;"> </form> <br>
</html>
    