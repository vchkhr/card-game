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

    /**
     * @param $player1
     * @param $player2
     * @return mixed
     */
    public function getBattleByPlayers($player1, $player2)
    {
        $request = "
        SELECT battles.id
        FROM battles
        WHERE player1 = '$player1'
        and player2 = '$player2';";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['id'];
    }

    public function getBattleByPlayer($player1)
    {
        $request = "
        SELECT battles.id
        FROM battles
        WHERE player1 = '$player1'
        or player2 = '$player1'
        LIMIT 1;";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($res['id']))
            return $res['id'];
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
        for ($i = 0; $res = $stmt->fetch(PDO::FETCH_ASSOC); $i++) {
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

    public function addBattleCard($login, $id, $hpCard, $damageCard, $manaCard, $cardCard)
    {
        $request = "SELECT addBattleCard('$login', $id, $hpCard, $damageCard, $manaCard,'$cardCard') as result;";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['result'];
    }

    public function startBattle($player1, $player2)
    {
        echo $player1;
        echo $player2;
        $request = "INSERT INTO battles(player1, player2) VALUE ('$player1', '$player2');";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        return $this->getBattleByPlayers($player1, $player2);
    }

    public function finishBattle($id)
    {
        $request = "SELECT finishBattle($id);";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
    }

    public function removeCard($id)
    {
        $request = "
        DELETE FROM battle_card
        WHERE battle_card.idCard = $id;";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
    }

    public function getBattleById($id)
    {
        $request = "
        SELECT *
        FROM battles
        WHERE id = $id;";
        $stmt = $this->connection->connection->prepare($request);
        try {
            $stmt->execute();
        }catch (Exception $e){}
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $battle = new Battle(
            $id,
            $res['player1'],
            $res['player2']
        );
        return $battle;

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