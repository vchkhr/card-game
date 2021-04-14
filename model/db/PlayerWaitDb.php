<?php


class PlayerWaitDb extends Model
{
    public $loginUser;
    public $waitingTime;
    public $data;

    public function addUser($loginUser, $data)
    {
        try {
        $this->loginUser = $loginUser;
        $this->data = $data;
        $request = "
            INSERT INTO player_wait(loginUser,data) VALUE
            ('$loginUser','$data');";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        } catch (Exception $e){}
    }

    public function removeUser($loginUser)
    {
        $this->loginUser = '';
        $this->data = '';
        $request = "
            DELETE FROM player_wait
            WHERE loginUser = '$loginUser';";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();

    }

    public function getUsers()
    {
        $request = "
            SELECT player_wait.loginUser, player_wait.data
            FROM player_wait;";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        $arrUser = array();
        for ($i = 0; $res = $stmt->fetch(PDO::FETCH_ASSOC); $i++) {
            $card = array();
            $card['loginUser'] = $res['loginUser'];
            $card['data'] = $res['data'];
//            $card->setData(
//                $res['idCard'],
//                $res['idBattle'],
//                $res['player'],
//                $res['hp'],
//                $res['damage'],
//                $res['mana'],
//                $res['card']
//            );
            $arrUser[$i] = $card;
        }

        return $arrUser;
    }
}