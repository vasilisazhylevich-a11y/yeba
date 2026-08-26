<?php

require_once __DIR__ . '/../classes/LVLInterface.php';
require_once __DIR__ . '/../classes/HPInterface.php';
require_once __DIR__ . '/../classes/AttackInterface.php';
require_once __DIR__ . '/../classes/DefenceInterface.php';
require_once __DIR__ . '/../classes/Hero.php';
require_once __DIR__ . '/../classes/Human.php';
require_once __DIR__ . '/../classes/Ork.php';
require_once __DIR__ . '/../classes/Elf.php';
require_once __DIR__ . '/../classes/Mob.php';
require_once __DIR__ . '/../core/BattleResult.php';

class Game
{

    public function start(): void
    {

        $action = $_GET['action'] ?? null;

        if (!isset($_SESSION['name']) || !isset($_SESSION['hero'])) {
            header('Location: index.php');
            exit;
        }

        $hero = $_SESSION['hero'];
        $result = null;

        if ($hero instanceof Human) {
            $result = $this->humanAction($hero, $action);
        } elseif ($hero instanceof Ork) {
            $result = $this->orkAction($hero);
        } elseif ($hero instanceof Elf) {
            $result = $this->elfAction($hero, $action);
        }

        $_SESSION['last_result'] = $result ? $result->toArray() : null;
        $_SESSION['hero'] = $hero;
        $mob = $_SESSION['mob'];
        if ($action === 'next_level') {
            if (!$mob->isAlive()) {
                $this->levelUpHero($hero);
                header('Location: fight.php');
                exit;
            }
        }

        if ($action === 'restart') {
            $hero->restoreFullHP();
            $mob = $this->getMobForLevel($hero->lvl());
            $_SESSION['mob'] = $mob;
            unset($_SESSION['isDefending']);
            unset($_SESSION['blocked_value']);
            unset($_SESSION['last_result']);
            $_SESSION['hero'] = $hero;
            header('Location: fight.php');
            exit;
        }


    }

    public function getMobForLevel(int $lvl): Mob
    {
        $mobs = [
            1 => ['name' => 'Крабан', 'hp' => 100],
            2 => ['name' => 'Варг', 'hp' => 200],
            3 => ['name' => 'Шелоб', 'hp' => 300],
            4 => ['name' => 'Балрог', 'hp' => 400],
            5 => ['name' => 'Босс: Лорд Саурон', 'hp' => 600],
        ];
        $data = $mobs[$lvl];
        return new Mob($data['name'], $lvl, $data['hp']);
    }

    private function humanAction(Human $hero, $action): BattleResult
    {
        $mob = $_SESSION['mob'];

        if ($action === 'Удар') {
            $damage = $hero->atk();
            $mob->takeDamage($damage);

            if (!$mob->isAlive()) {
                $this->levelUpHero($hero);
                return new BattleResult(
                    $damage,
                    0,
                    "Вы нанесли {$damage} ед.урона и зло было повержено!",
                    "Враг повержен!",
                    null
                );
            }

            $mobDamage = $this->mobTurn($hero, $mob);
            $_SESSION['mob'] = $mob;

            return new BattleResult(
                $damage,
                $mobDamage,
                "Вы нанесли {$damage} ед.урона!",
                "Враг нанес {$mobDamage} урона!",
                null
            );
        }

        if ($action === 'Блок') {
            $_SESSION['isDefending'] = true;
            $blocked = $hero->def();
            $_SESSION['blocked_value'] = $blocked;

            $mobDamage = $this->mobTurn($hero, $mob);
            $_SESSION['mob'] = $mob;

            return new BattleResult(
                0,
                $mobDamage,
                "Вы заблокировали {$blocked} ед.урона!",
                "Враг нанес {$mobDamage} урона!",
                null
            );
        }

        return new BattleResult(0, 0, "Неизвестное действие", "", null);
    }

    private function orkAction(Ork $hero): BattleResult
    {
        $mob = $_SESSION['mob'];
        $damage = $hero->atk();
        $rageActive = $hero->isRageActive();
        $mob->takeDamage($damage);

        if (!$mob->isAlive()) {
            $this->levelUpHero($hero);
            return new BattleResult(
                $damage,
                0,
                "Вы нанесли {$damage} ед.урона и зло было повержено!",
                "Враг повержен!",
                $rageActive ? "Ярость активирована! +15% к урону!" : null
            );
        }

        $mobDamage = $this->mobTurn($hero, $mob);
        $_SESSION['mob'] = $mob;

        return new BattleResult(
            $damage,
            $mobDamage,
            "Вы нанесли {$damage} урона!",
            "Враг нанес {$mobDamage} урона!",
            $rageActive ? "Ярость активирована! +15% к урону!" : null
        );
    }

    private function elfAction(Elf $hero, $action): BattleResult
    {
        $mob = $_SESSION['mob'];

        if ($action === 'Удар ножом') {
            $damage = $hero->atk();
        } elseif ($action === 'Выстрел из лука') {
            $damage = $hero->rangeAtk();
        } else {
            return new BattleResult(0, 0, "Неизвестное действие", "", null);
        }

        $mob->takeDamage($damage);

        if (!$mob->isAlive()) {
            $this->levelUpHero($hero);
            return new BattleResult(
                $damage,
                0,
                "Вы нанесли {$damage} урона и зло было повержено!",
                "Враг повержен!",
                null
            );
        }

        $mobDamage = $this->mobTurn($hero, $mob);
        $_SESSION['mob'] = $mob;

        return new BattleResult(
            $damage,
            $mobDamage,
            "Вы нанесли {$damage} урона!",
            "Враг нанес {$mobDamage} урона!",
            null
        );
    }

    private function mobTurn(Hero $hero, Mob $mob): int
    {
        $damage = 0;

        if (isset($_SESSION['isDefending']) && $_SESSION['isDefending'] === true) {
            $damage = $mob->mobAtk() - $_SESSION['blocked_value'];
            if ($damage < 0) $damage = 0;
            $_SESSION['isDefending'] = false;
            unset($_SESSION['blocked_value']);
        } else {
            $damage = $mob->mobAtk();
        }

        if ($damage > 0) {
            $hero->takeDamage($damage);
            $_SESSION['hero'] = $hero;
        }

        return $damage;
    }
    private function checkGameEnd(Hero $hero): bool
    {
        if ($hero->lvl() > 5) {
            header('Location: end.php');
            exit;
        }
        return false;
    }

    private function levelUpHero(Hero $hero): void
    {
        $hero->lvlUP();
        $_SESSION['hero'] = $hero;
        $this->checkGameEnd($hero);
        if ($this->checkGameEnd($hero)) {
            return;
        }
        $newMob = $this->getMobForLevel($hero->lvl());
        $_SESSION['mob'] = $newMob;

    }

}