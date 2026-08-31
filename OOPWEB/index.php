<?php
require_once __DIR__ . '/classes/LVLInterface.php';
require_once __DIR__ . '/classes/HPInterface.php';
require_once __DIR__ . '/classes/AttackInterface.php';
require_once __DIR__ . '/classes/DefenceInterface.php';
require_once __DIR__ . '/classes/Hero.php';
require_once __DIR__ . '/classes/Human.php';
require_once __DIR__ . '/classes/Ork.php';
require_once __DIR__ . '/classes/Elf.php';
require_once __DIR__ . '/classes/Mob.php';

session_start();
// Если игрок уже начал игру — можно перенаправить на fight.php
if (isset($_SESSION['hero'])) {
    header('Location: fight.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Выбор героя</title>
    <style>

    </style>
</head>
<body>
<div class="container">
    <h1> Выбери своего героя</h1>
    <form action="fight.php" method="GET">
        <div class="form-group">
            <label for="name">Имя персонажа:</label>
            <input type="text" id="name" name="name" required placeholder="Введите имя">
        </div>

        <div class="form-group">
            <label for="race">Раса:</label>
            <select id="race" name="race" required>
                <option value="Человек">Человек</option>
                <option value="Орк">Орк</option>
                <option value="Эльф">Эльф</option>
            </select>
        </div>

        <div class="race-info">
            <div class="race-desc" data-race="Человек">
                <img src="images/человек.jpg" alt="Человек" width="50">
                <strong>Люди</strong> — со всеми его слабостями, стремлением к власти, жаждой победить смерть и одновременно способностью к бескорыстной самоотверженности,
                люди способны на величайшие подвиги и перемены.
                (Способны не только атаковать, но и защищаться)
            </div>
            <div class="race-desc" data-race="Орк">
                <img src="images/орк.jpg" alt="Орк" width="50">
                <strong>Орки</strong> — приземистые, безобразные и злобные существа, созданные в результате тёмного искажения Детей Илуватара.
                (Имеют особенный навык "ярость", который дает +15% к атаке если бьют "слабее чем ожидали")
            </div>
            <div class="race-desc" data-race="Эльф">
                <img src="images/эльф.jpg" alt="Эльф" width="50">
                <strong>Эльфы</strong> — прекрасный, мудрый и высокий народ, «старшие дети Илуватара»,
                обладающие бессмертием и глубокой связью с природой.
                (Искуссные стрелки, потому имеют больше единиц урона от дальних атак)
            </div>
        </div>

        <button type="submit" class="btn">Начать игру</button>
    </form>
</div>
</body>
</html>