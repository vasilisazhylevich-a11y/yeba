<?php

class BattleResult
{
    private int $playerDamage;
    private int $mobDamage;
    private string $playerMessage;
    private string $mobMessage;
    private ?string $specialMessage; // ? означает что может быть null

    public function __construct(
        int     $playerDamage,
        int     $mobDamage,
        string  $playerMessage,
        string  $mobMessage,
        ?string $specialMessage = null // опциональный параметр
    )
    {
        $this->playerDamage = $playerDamage;
        $this->mobDamage = $mobDamage;
        $this->playerMessage = $playerMessage;
        $this->mobMessage = $mobMessage;
        $this->specialMessage = $specialMessage;
    }

    public function toArray(): array
    {
        $data = [
            'playerDamage' => $this->playerDamage,
            'mobDamage' => $this->mobDamage,
            'playerMessage' => $this->playerMessage,
            'mobMessage' => $this->mobMessage
        ];

        if ($this->specialMessage !== null) {
            $data['specialMessage'] = $this->specialMessage;
        }

        return $data;
    }


    public function getPlayerDamage(): int
    {
        return $this->playerDamage;
    }

    public function getMobDamage(): int
    {
        return $this->mobDamage;
    }

}
