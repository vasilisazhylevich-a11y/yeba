<?php

class Mob implements HPInterface {
    private int $hp;
    private int $maxHp;
    private int $lvl;
    private string $name;

    public function __construct(string $name, int $lvl, int $maxHp) {
        $this->name = $name;
        $this->lvl = $lvl;
        $this->maxHp = $maxHp;
        $this->hp = $this->maxHp;
    }
    public function lvl(): int
    {
        return $this->lvl;
    }
    public function getName(): string {
        return $this->name;
    }
    public function mobAtk(): int {
        $mobatk =  (rand(10, 20) * $this->lvl());
        return $mobatk;
    }
    public function maxHp(): int
    {
        return $this->maxHp;
    }
    public function hp(): int
    {
        return $this->hp;
    }
    public function takeDamage(int $damage): void {
        $this->hp -= $damage;
        if ($this->hp < 0) $this->hp = 0;
    }

    public function isAlive(): bool {
        return $this->hp > 0;
    }
}
