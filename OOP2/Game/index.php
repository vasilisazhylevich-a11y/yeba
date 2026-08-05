<?php

require_once __DIR__ . '/classes/AttackInterface.php';
require_once __DIR__ . '/classes/DefenceInterface.php';
require_once __DIR__ . '/classes/Hero.php';
require_once __DIR__ . '/classes/Human.php';
require_once __DIR__ . '/classes/Ork.php';
require_once __DIR__ . '/classes/Elf.php';

class Game
{
    public function start(): void
    {
      
        $name = readline('Введите имя: ');
        echo "\nВыберите расу:\n";
        echo "1. Чебловек\n";
        echo "2. Оркис\n";
        echo "3. Ушастый\n";

        $raceChoice = readline('Введите номер варианта: ');
        $raceChoice = trim($raceChoice);

      
        switch ($raceChoice) {
            case '1':
                $hero = new Human($name, "Чебловек");
                echo "\n$name, вы чебловек!\n";
                break;

            case '2':
                $hero = new Ork($name, "Оркис");
                echo "\n$name, вы орк, может лучше сходить в душ?\n";
                break;

            case '3':
                $hero = new Elf($name, "Ушастый");
                echo "\n$name, вы выбрали эльфа, фанат Леголаса?\n";
                break;

            default:
                echo "\nТакого варианта нет. Игра завершена.\n";
                return;
        }

    
        echo "\n НУ НАЧИНАЕТСЯ \n";

        if ($hero instanceof Human) {
            $this->humanAction($hero);
        } elseif ($hero instanceof Ork) {
            $this->orkAction($hero);
        } elseif ($hero instanceof Elf) {
            $this->elfAction($hero);
        }
    }

    private function humanAction(Human $hero): void
    {
        echo "\nВыберите действие:\n";
        echo "1. Физическая атака\n";
        echo "2. Магическая атака\n";
        echo "3. Защита\n";

        $action = readline("Введите номер действия: ");
        $action = trim($action);

        echo "\n";

        switch ($action) {
            case '1':
                $damage = $hero->atk();
                echo " {$hero->getName()} вьебал аж на: $damage единиц!\n";
                break;
            case '2':
                $damage = $hero->magicAtk();
                echo " {$hero->getName()} колдует и ебает: $damage единиц урона!\n";
                break;
            case '3':
                $blocked = $hero->def();
                echo " {$hero->getName()} блокирует $blocked единиц урона!\n";
                break;
            default:
                echo "Неверный выбор!\n";
        }
    }

    private function orkAction(Ork $hero): void
    {
        echo "\nОрк ща вьебет!\n";

        $damage = $hero->atk();
        $rageActive = $hero->isRageActive();

        echo "\n";
        if ($rageActive) {
            echo "Орк не смог нормально въебать и разозлился! +15% к урону!\n";
        }
        echo " {$hero->getName()} вьебал на: $damage единиц урона!\n";
    }

    private function elfAction(Elf $hero): void
    {
        echo "\nВыберите тип атаки:\n";
        echo "1. Ближняя атака (кинжал)\n";
        echo "2. Дальняя атака (лук)\n";

        $action = readline("Введите номер действия: ");
        $action = trim($action);

        echo "\n";

        switch ($action) {
            case '1':
                $damage = $hero->atk();
                echo "{$hero->getName()} тыкнул ножиком на: $damage единиц урона!\n";
                break;
            case '2':
                $damage = $hero->rangeAtk();
                echo "{$hero->getName()} зассал и стрельнул издалека: $damage единиц урона!\n";
                break;
            default:
                echo "Неверный выбор!\n";
        }
    }
}

$game = new Game();
$game->start();

echo "\n НУ ВСЁ\n";