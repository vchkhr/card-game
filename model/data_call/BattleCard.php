<?php


class BattleCard
{
    public $idBattle;
    public $playerLogin;
    public $card;

    /**
     * BattleCard constructor.
     * @param $idBattle
     * @param $playerLogin
     * @param $card
     */
    public function __construct($idBattle, $playerLogin, $card)
    {
        $this->idBattle = $idBattle;
        $this->playerLogin = $playerLogin;
        $this->card = $card;
    }


}