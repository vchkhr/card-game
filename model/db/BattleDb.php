<?php


class BattleDb extends Model
{
    public $player1Login, $player2Login;

    public function __construct()
    {
        parent::__construct();
    }

    function createNewBattle($player1, $player2)
    {

    }

    private function isEmpty()
    {

    }

    public function getCard($idBattle, $player)
    {
        $request = "
            SELECT *
            FROM battle_card
            JOIN battles b on b.id = battle_card.idBattle
            WHERE player = '$player'
            and idBattle = $idBattle;";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
//        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $arrCard = array();
        for ($i=0;$res = $stmt->fetch(PDO::FETCH_ASSOC);$i++) {
            $card = new BattleCard();
            $card->setData(
                $res['idCard'],
                $res['idBattle'],
                $res['player'],
                $res['hp'],
                $res['damage'],
                $res['mana'],
                $res['card']
            );
            $arrCard[$i] = $card;
        }
        return $arrCard;
    }

    public function addBattleCard($login, $id, $hpCard, $damageCard, $manaCard, $cardCard){
        $request = "SELECT addBattleCard('$login', $id, $hpCard, $damageCard, $manaCard,'$cardCard') as result;";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['result'];
    }
}

//                          $card->idCard =
//                          $card->idBattle =
//                          $card->playerLogin =
//                          $card->hp =
//                          $card->damage =
//                          $card->mana =
//                          $card->card =


//battle_card.hp, battle_card.damage,battle_card.mana ,battle_card.card