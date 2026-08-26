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
require_once __DIR__ . '/core/Game.php';

session_start();

if (isset($_GET['name']) && isset($_GET['race']) && !isset($_SESSION['hero'])) {
    $name = $_GET['name'];
    $race = $_GET['race'];

    switch ($race) {
        case 'Человек':
            $hero = new Human($name, $race, 120, 120, 1);
            break;
        case 'Орк':
            $hero = new Ork($name, $race, 120, 120, 1);
            break;
        case 'Эльф':
            $hero = new Elf($name, $race, 140, 140, 1);
            break;
        default:
            header('Location: index.php');
            exit;
    }
    $_SESSION['hero'] = $hero;
    $_SESSION['name'] = $name;
    $game = new Game();
    $mob = $game->getMobForLevel(1);
    $_SESSION['mob'] = $mob;
    header('Location: fight.php');
    exit;

    }

$hero = $_SESSION['hero'] ?? null;
$mob = $_SESSION['mob'] ?? null;
$result = $_SESSION['last_result'] ?? null;
if (!$hero || !$mob) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['action'])) {
    $game = new Game();
    $game->start();
    header('Location: fight.php');
    exit;

}
?>
<!DOCTYPE html>
<html>
<head>
    <head> fight </head>
    <style>
        /*стили
    </style>
</head>
<body>
<h1>В Бой!</h1>
<div class="hero-info">
    <h2><?= $hero->getName() ?> <?= $hero->getRace() ?>  (Уровень персонажа: <?= $hero->lvl() ?>)</h2>
    <div class="hp-bar">
        <div style="width: <?= ($hero->hp() / $hero->maxHp()) * 100 ?>%"></div>
    </div>
    <span><?= $hero->hp() ?> / <?= $hero->maxHp() ?></span>
</div>
<div class="mob-info">
    <h2><?= $mob->getName() ?> (Уровень: <?= $mob->lvl() ?>)</h2>
    <div class="hp-bar">
        <div style="width: <?= ($mob->hp() / $mob->maxHp()) * 100 ?>%"></div>
    </div>
    <span><?= $mob->hp() ?> / <?= $mob->maxHp() ?></span>
</div>

<div class="actions">
    <?php if ($hero->isAlive()): ?>
    <?php if ($hero instanceof Human):?>
        <a href="?action=Удар">Удар</a>
        <a href="?action=Блок">Блок</a>
    <?php endif; ?>
    <?php if ($hero instanceof Elf):?>
        <a href="?action=Удар ножом">Удар ножом</a>
        <a href="?action=Выстрел из лука">Выстрел из лука</a>
    <?php endif; ?>
    <?php if ($hero instanceof Ork):?>
        <a href="?action=Удар">Удар</a>
    <?php endif; ?>
    <?php endif; ?>
</div>
<div class="result">
    <?php if ($result): ?>

        <?php if (isset($result['playerMessage'])): ?>
            <p><?= $result['playerMessage'] ?></p>
        <?php endif; ?>


        <?php if (isset($result['mobMessage'])): ?>
            <p><?= $result['mobMessage'] ?></p>
        <?php endif; ?>

        <?php if (isset($result['specialMessage'])): ?>
            <p class="special"><?= $result['specialMessage'] ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php if (!$mob->isAlive()): ?>
    <div class="modal-overlay">
        <div class="modal">
            <h2>Победа!</h2>
            <p>Вы повергли врага!</p>
            <div class="modal-actions">
                <?php if ($hero->lvl() <= 5): ?>
                    <a href="?action=next_level">Следующий уровень</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (!$hero->isAlive()): ?>
    <div class="modal-overlay">
        <div class="modal">
            <h2>Поражение!</h2>
            <p>Вы пали в бою...</p>
            <div class="modal-actions">
                <a href="?action=restart"" class="btn">Пройти еще раз</a>
            </div>
        </div>
    </div>
<?php endif; ?>


</body>
</html>
