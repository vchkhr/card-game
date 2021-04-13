<?php

class Player
{
    public $hp;
    public $name;
    public $imgUrl;
    public $cards = array();

    /**
     * Player constructor.
     * @param $hp
     * @param $name
     * @param $imgUrl
     */
    public function __construct($hp, $name, $imgUrl = "./res/img/profile.png")
    {
        $this->hp = $hp;
        $this->name = $name;
        $this->imgUrl = $imgUrl;
    }
}
