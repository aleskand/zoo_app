<?php
// hasło i login do strony jako admin
define('USERNAME', 'admin');
define('PASSWORD', '$2y$10$EYJtIebyLu..rYppKGEz0e3ASfL/QqBeJmifTx7oKJEFEMW9P9mra'); # karamba

session_start();

if (!empty($_POST['login']) && !empty($_POST['password']))
{
    if ($_POST['login'] == USERNAME)
    {
        if (password_verify($_POST['password'], PASSWORD))
        {
            $_SESSION['user'] = htmlspecialchars($_POST['login']);
            include 'zalogowany.php';
              
        }else {
            echo "Adminie, podałeś błędne hasło! Spróbuj ponownie.";
            echo "<br/>";
            echo "Zaraz zostaniesz przekierowany ponownie na stronę logowania.";
            header('Refresh: 4; URL=https://students.mimuw.edu.pl/~as420561/index.php?');                       
        }
    } else {
        // logowanie pracownika
        $login = $_POST['login'];
        $password = $_POST['password'];
        
        // połączenie z bazą
        $link = pg_connect("host=lkdb dbname=mrbd user=as420561 password=Kubek2807");
        if (!$link) {
            print("Błąd połączenia z bazą danych.");
        exit;
        }

        $name = "SELECT * FROM Pracownik WHERE id_pracownika=$login";
        $szukaj = pg_query_params($link,"SELECT imie FROM Pracownik WHERE id_pracownika= $1", array($login));
        $rf = pg_fetch_assoc($szukaj);
        $imie = $rf['imie'];
        $result = pg_query($name);
        $resultCheck = pg_numrows($result);
        if($resultCheck > 0 && $password == 'ogrod'){
            // poprawnie zalogowany pracownik
            $_SESSION['user'] = htmlspecialchars($imie);
            include 'zalogowany_pracownik.php';
            }else{
                // niepoprawne dane logowania pracownika
                echo "Pracowniku, podałeś błędne dane do logowania! Spróbuj ponownie.";
                echo "<br/>";
                echo "Zaraz zostaniesz przekierowany ponownie na stronę logowania.";
                header('Refresh: 4; URL=https://students.mimuw.edu.pl/~as420561/index.php?');
            }   
    }
}