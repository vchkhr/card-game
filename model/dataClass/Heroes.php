<?php

class Heroes
{
    public $name;
    public $hp;
    public $damage;
    public $imgUrl;
    public $price;

    public function __construct($name, $hp, $damage, $imgUrl, $price)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->damage = $damage;
        $this->imgUrl = $imgUrl;
        $this->price = $price;
    }
}
