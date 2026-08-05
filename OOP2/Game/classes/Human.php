<?php

class Human extends Hero implements DefenceInterface
{
    public function atk(): int
    {
        return rand(1, 100);
    }

    public function def(): int
    {
        return rand(1, 50);
    }

    public function magicAtk(): int
    {
        return rand(5, 90);
    }
}