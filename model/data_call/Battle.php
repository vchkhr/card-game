<?php


class Battle
{
    public $idBattle;
    public $player1;
    public $player2;

    /**
     * Battle constructor.
     * @param $idBattle
     * @param $player1
     * @param $player2
     */
    public function __construct($idBattle, $player1, $player2)
    {
        $this->idBattle = $idBattle;
        $this->player1 = $player1;
        $this->player2 = $player2;
    }


}