<?php


class Player
{
    public $hp;
    public $name;
    public $imgUrl = "";
    public $cards = array();

    /**
     * Player constructor.
     * @param $hp
     * @param $name
     * @param $imgUrl
     */
    public function __construct($hp, $name, $imgUrl = "")
    {
        $this->hp = $hp;
        $this->name = $name;
        $this->imgUrl = $imgUrl;

        if ($imgUrl == "") {
            $this->imgUrl = "./res/img/profile.png";
        }
    }

    public function printCard()
    {
        echo "User card:";
        print_r($this->cards);
//        foreach ($this->cards as $card){
//            echo "$card <br>";
//        }
    }

}
