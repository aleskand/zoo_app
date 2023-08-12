<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
</head>
<body>
<h1 align="center"> Centrum dowodzenia ogrodem botanicznym</h1>
<center>
Pracowniku,
miło wiedzieć Cię w pracy! <br/>
Wpisz proszę poprawne dane logowania - nazwa to twój nr ID, hasło powinieneś znać.
</center>
<br/>
    <?php if (empty($_SESSION['user'])) : ?>
    <form action="login.php" method="post">
      <center>
      <input type="text" name="login" placeholder="Nazwa" required />
      <br/>
      <br/>
      <input type="password" name="password" placeholder="Hasło" required />
      <br/>
      <br/>
      <button type="submit" style="background-color: #5F9EA0;">Zaloguj się</button>
    </form>
    <?php else :
      header("Location: https://students.mimuw.edu.pl/~as420561/zalogowany.php?"); ?>
      
    <?php endif; ?>
<br/>
<br/>
<img src="tlo.jpg" width="400" height="600">
</body>
</html>



