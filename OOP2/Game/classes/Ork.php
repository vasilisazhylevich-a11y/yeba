<?php

class Ork extends Hero
{
    private bool $rageActive = false;

    public function atk(): int
    {
        $atk = rand(1, 100);
        $this->rageActive = false;

        if ($atk <= 50) {
            $this->rageActive = true;
            $atk = $atk + ($atk * 0.15);
        }

        return (int) $atk;
    }

    public function isRageActive(): bool
    {
        return $this->rageActive;
    }
}