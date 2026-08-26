<?php

class Human extends Hero implements DefenceInterface
{
    public function atk(): int {
        $atk = rand(50,80) + (10 * $this->lvl());
        return $atk;
    }
    public function def(): int {
        $def = 10 * $this->lvl();
        return $def;
    }

}

