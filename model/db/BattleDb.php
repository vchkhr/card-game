<?php


class BattleDb extends Model
{
    public $player1Login, $player2Login;

    function createNewBattle($player1, $player2)
    {
        $request = "
                    SELECT 1 as isntEmpty
                    FROM players
                    WHERE login =  '$this->login';";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();

    }

    private function isEmpty()
    {

    }
}