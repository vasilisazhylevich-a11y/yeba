<?php

abstract class Hero implements AttackInterface
{
    private string $name;
    private string $race;

    public function __construct(string $name, string $race)
    {
        $this->name = $name;
        $this->race = $race;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    abstract public function atk(): int;
}
