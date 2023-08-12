<?php
session_start();
unset($_SESSION['user']);
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
</head>
<body style="background-color: #F0F8FF;">
<h1 align="center"> Dziękuję za pracę, do zobaczenia następnym razem!</h1>
<br/><center>
Wylogowałeś się przez pomyłkę?
<br/>
<br/>
<form action = "index.php"> <input type = "submit" value = "Zaloguj się ponownie" style="background-color: #5F9EA0;"> </form> <br>
<img src="logout.JPG" width="600" height="400">
</center>
</body>
</html>


