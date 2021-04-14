<?php


class BattleCard
{
    public $idCard;
    public $idBattle;
    public $playerLogin;
    public $hp;
    public $damage;
    public $mana;
    public $card;

    /**
     * BattleCard constructor.
     * @param $idCard
     * @param $idBattle
     * @param $playerLogin
     * @param $hp
     * @param $damage
     * @param $mana
     * @param $card
     */
    public function setData($idCard, $idBattle, $playerLogin, $hp, $damage, $mana, $card)
    {
        $this->idCard = $idCard;
        $this->idBattle = $idBattle;
        $this->playerLogin = $playerLogin;
        $this->hp = $hp;
        $this->damage = $damage;
        $this->mana = $mana;
        $this->card = $card;
    }



}