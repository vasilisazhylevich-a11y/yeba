<?php

class Ork extends Hero
{
    private bool $rageActive = false;

    public function atk(): int {
        $atk = rand(5, 100) * $this->lvl();

        if ($atk <= 50) {
            $this->rageActive = true;
            $atk = $atk + ($atk * 0.15);
        } else {
            $this->rageActive = false;
        }

        return (int) $atk;
    }

    public function isRageActive(): bool {
        return $this->rageActive;
    }
}