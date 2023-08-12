<html>
<head>
<title>Lista projektów</title>
</head>
<body bgcolor="white">

<?php
session_start();
$link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");

if (!$link) {
  print("Błąd połączenia z bazą.");
  exit;
}

$result = pg_query($link, "select id_zadania, dataz, id_pracownika, id_projektu, id_specjalnosci from Zadania");
$numrows = pg_numrows($result);

$id_zad = $_POST["zadanie"];

if(isset($_POST['submit'])){
  // użytkownik podaje nową datę
  echo '<form method="post">';
  echo '<br>';
  echo 'Data: <input type="date" name="nowa_data" required><br>';
  echo '<br>';
  echo '<b style="color:red">UWAGA: Wybierz datę conajmniej dzisiejszą! Nie można dodawać zadań wstecz.</b><br>';
  echo '<br>';
  echo '<input type=submit value="Zmień datę" name="submit2">';
  echo '</form>';

  // zmienna przekazywana dalej
  $_SESSION['zadanie'] = $id_zad;
}

if(isset($_POST['submit2'])){
  // mamy nową datę od użwytkownika, sprawdzam czy jest poprawna
  $n_data = $_POST["nowa_data"];
  $id_zadania = $_SESSION['zadanie'];
  $now = strtotime(date('Y-m-d'));
  if(strtotime($n_data) < $now) {
    header("Location: https://students.mimuw.edu.pl/~as420561/blad_daty2.php?");
  }

  // sprawdzam czy nowa data jest inna niż stara
  $row_zad =  pg_query_params($link, "Select dataz from Zadania Where id_zadania = $1", array($id_zadania));
  $row2 = pg_fetch_assoc($row_zad);
  $data_dozmiany = $row2['dataz'];
  if(strtotime($data_dozmiany) == strtotime($n_data)) {
    header("Location: https://students.mimuw.edu.pl/~as420561/blad_daty3.php?");
  }

  // pobieram ID projektu i ID pracownika obecnego zadania
  // pobieranie ID pracownika
  $res1 = pg_query_params($link, "SELECT ID_pracownika FROM Zadania WHERE id_zadania= $1", array($id_zadania));
  $row1 = pg_fetch_assoc($res1);
  $id_pracownik = $row1['id_pracownika'];

  // pobieranie ID projektu
  $res2 = pg_query_params($link, "SELECT ID_projektu FROM Zadania WHERE id_zadania= $1", array($id_zadania));
  $row2 = pg_fetch_assoc($res2);
  $id_projekt = $row2['id_projektu'];
  $ok = TRUE;

  // sprawdzam czy data jest ok względem innych ograniczeń:
  // czy pracownik nie ma wtedy innego zadania? = czy pracownik jest wolny
  $lista_idprac_data = pg_query_params($link, "Select id_pracownika from Zadania Where dataz = $1", array($n_data));
  $numrowsprac = pg_numrows($lista_idprac_data);
  //czy projekt nie ma wtedy innego zadania? = czy projekt jest wolny
  $lista_idprojektu_data = pg_query_params($link, "Select id_projektu from Zadania Where dataz = $1", array($n_data));
  $numrowspro = pg_numrows($lista_idprojektu_data);
  if ($numrowsprac > 0){
    // jeśli jest większy od zera to sprawdzam czy jest w tej liście nasz pracownik
    $lista_id_prac = pg_fetch_array($lista_idprac_data)['id_pracownika'];
    $lista_prac = explode(" ", $lista_id_prac);
    if (in_array($id_pracownik, $lista_prac)){
      $ok = FALSE;
      header("Location: https://students.mimuw.edu.pl/~as420561/blad_daty4.php?");
    }
  } 
  
  if ($numrowspro > 0){
    // jeśli jest większy od zera to sprawdzam czy jest w tej liście nasz projekt
    $lista_id_projekt = pg_fetch_array($lista_idprojektu_data);
    if (in_array($id_projekt, $lista_id_projekt)){
      $ok = FALSE;
      header("Location: https://students.mimuw.edu.pl/~as420561/blad_daty5.php?");
    }
  } 
  
  if ($ok) {
    // data ok - wrzucam do bazy
    $wynik = pg_query_params($link,
                      "UPDATE Zadania SET dataz= $1 WHERE id_zadania= $id_zadania", array($n_data));
    if ($wynik) {
      echo "Data została poprawnie zmieniona.<br>";
      echo "</br>";
      echo "<form action = 'zalogowany.php'> <input type = 'submit' value = 'Wróć na stronę główną' style='background-color: #5F9EA0;'> </form> <br>";
      echo "Lub zmień datę kolejnego zadania: ";
      echo "<br>";
      echo "<form action = 'zmiana_daty.php'> <input type = 'submit' value = 'Zmień kolejną datę' style='background-color: #5F9EA0;'> </form> <br>";
      echo "<br>";
    }
    else {
      echo "Nie udało się zmienić daty! Spróbuj ponownie.<br>";
      echo "<br>";
      echo pg_last_error($link) . "<br>";
      echo "<form action = 'zalogowany.php'> <input type = 'submit' value = 'Wróć na stronę główną' style='background-color: #5F9EA0;'> </form> <br>";
      echo "Lub zmień datę kolejnego zadania:  ";
      echo "<form action = 'zmiana_daty.php'> <input type = 'submit' value = 'Zmień kolejną datę' style='background-color: #5F9EA0;'> </form> <br>";
      echo "<br>";
    }
  }
}
?>
</body>
</html>

