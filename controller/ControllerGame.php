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

    function turnPlayer($id, $arrayCard)
    {
        foreach ($arrayCard as $i => $card) {
            if ($id == 1)
                $this->attackToUser($this->player1, $card->damage);
            else
                $this->attackToUser($this->player2,$card->damage);
        }
    }

    private function attackToUser($user, $damage)
    {
        $damageToCard = $damage;
        foreach ($user->cards as $i => $card) {
            $damageToCard = $this->attackToCard($user, $card, $damageToCard);
            if ($card->hp <= 0)
                unset($user->cards[$i]);
            if ($damageToCard <= 0)
                break;
        }
        if ($damageToCard > 0)
            $user->hp -= $damageToCard;
        if ($user->hp <= 0) {
            $this->losePlayer($user);
        }
        $this->removedHeroes();
    }

    private function attackToCard($user, $card, $damage)
    {
        $mod = $damage - $card->hp;
        $card->hp -= $damage;
        return $mod;
    }

    public function turnBot()
    {
        foreach ($this->player1->cards as $card) {
            if ($card->price < $this->turn) {
                $this->attackToUser($this->player2, $card->damage);
                return;
            }
        }
    }

    private function losePlayer($user)
    {
    }

    private function removedHeroes()
    {

        foreach ($this->player2->cards as $i => $value) {
            if (isset($this->player1->cards[$i]) && $this->player1->cards[$i]->hp <= 0)
                unset($this->player1->cards[$i]);
        }
        foreach ($this->player2->cards as $i => $value) {
            if (isset($this->player21->cards[$i]) && $this->player2->cards[$i]->hp <= 0)
                unset($this->player2->cards[$i]);
        }
    }
}