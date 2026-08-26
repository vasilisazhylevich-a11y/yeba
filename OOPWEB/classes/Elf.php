<?php

class Elf extends Hero
{
    public function atk(): int
    {
        $atk = rand(20,50) + (10 * $this->lvl());
        return $atk;
    }

    public function rangeAtk(): int
    {
        $atk = rand(50,80) + (10 * $this->lvl());
        return $atk;
    }
}