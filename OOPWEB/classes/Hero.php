<?php

abstract class Hero implements AttackInterface, HPInterface //абстрактный класс
{
    private int  $maxHp;
    private int  $hp;
    private int $lvl;
    private string $name;
    private string $race;
    public function __construct(string $name, string $race, int $hp, int $maxHp, int $lvl) { //задаем имя и рассу
        $this->name = $name;
        $this->race = $race;
        $this->hp = $hp;
        $this->maxHp = $maxHp;
        $this->lvl = $lvl;
    }

    public function maxHp(): int
    {
        return $this->maxHp;
    }
    public function hp(): int
    {
        return $this->hp ;
    }
    public function lvl(): int
    {
        return $this->lvl;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getRace(): string {
        return $this->race;
    }
    public function getMaxHp(): int {
        return $this->maxHp;
    }
    public function getHP(): int {
        return $this->hp;
    }

    public function getLvl(): int
    {
        return $this->lvl;
    }

    public function lvlUP(): void {
        $this->lvl++;
        $this->maxHp = 100 * $this->lvl;
        $this->hp = $this->maxHp;
    }

    public function takeDamage(int $damage): void
    {
        $this->hp -= $damage;
        if ($this->hp < 0) $this->hp = 0;
    }

    public function isAlive(): bool {
        return $this->hp > 0;
    }
        abstract public function atk(): int;

    public function restoreFullHP(): void {
        $this->hp = $this->maxHp;
    }
}
