<?php
// конец игры (победа/поражение/рестарт)
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>victory!</title>
    <style>

    </style>
</head>
<body>
<div class="container">
    <h1>Вы победили зло!</h1>
    <p>Тьма повержена, Средиземье спасено!</p>
    <p>Вы прошли игру за <strong><?= $_SESSION['name'] ?? 'Герой' ?></strong></p>
    <a href="logout.php" class="btn"> Играть заново</a>
</div>
</body>
</html>