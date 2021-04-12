<?php


class ControllerGame
{
    public $arrayHeroes = array();
    public $player1;
    public $player2;

    private $turn = 1;

    /**
     * ControllerGame constructor.
     * @param $player1
     * @param $player2
     */
    public function __construct($player1, $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    private function attackToUser($user, $damage)
    {
        $damageToCard = $damage / count($user->cards);
        foreach ($user->cards as $card) {
            $this->attackToCard($user, $card, $damageToCard);
        }
        if ($user->hp <= 0) {
            $this->losePlayer($user);
        }
    }

    private function attackToCard($user, $card, $damage)
    {
        $mod = $card->hp - $damage;
        if ($mod >= 0) {
            $card->hp = $mod;
        } else {
            $card->hp = 0;
            $user->hp -= $mod;
        }
    }

    private function turnBot()
    {
        foreach ($this->player1->cards as $card) {
            if ($card->price<$this->turn){
                $this->attackToUser($this->player2,$card->damage);
                return;
            }
        }
    }

    private function losePlayer($user)
    {
    }
}