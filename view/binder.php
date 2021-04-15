<?php
class Binder
{
    private $manager;

    public function __construct($navManager)
    {
        $this->manager = $navManager;
    }

    public function startBattle($loginUser, $player2){
        $dbPlayer = new UserDB();
        $dbPlayer->login = $loginUser;
        $dbPlayer->find($loginUser);
        $user1 = $dbPlayer->login;
        $user1Img = $dbPlayer->img;
        $dbPlayer->find($player2);
        $user2 = $dbPlayer->login;
        $user2Img = $dbPlayer->img;

        $this->manager->changeScreen('game');
        $this->manager->bind("PLAYER_1_NAME", $loginUser);
        $this->manager->bind("PLAYER_2_NAME", $player2);
        $this->manager->bind("PLAYER_1_IMG", $user1Img);
        $this->manager->bind("PLAYER_2_IMG", $user2Img);
        $this->manager->render();
    }

    // public function startBattle($user1, $user2){
    //     $this->manager->changeScreen('game');
    //     $this->manager->bind("PLAYER_1_NAME", $user1->name);
    //     $this->manager->bind("PLAYER_2_NAME", $user2->name);
    //     $this->manager->bind("PLAYER_1_HEALTH", $user1->name);
    //     $this->manager->bind("PLAYER_2_HEALTH", $user2->name);
    //     $this->manager->render();
    // }

    public function startWaitPlayer($userName1){
        $this->manager->changeScreen('waitPlayer');
        $this->manager->bind("USER_NAME", $userName1);
        $this->manager->render();
    }
}
