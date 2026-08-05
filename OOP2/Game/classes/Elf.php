<?php

class Elf extends Hero
{
    public function atk(): int
    {
        return rand(1, 100);
    }

    public function rangeAtk(): int
    {
        return rand(5, 90);
    }
}