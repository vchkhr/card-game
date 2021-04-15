<?php
class Binder
{
    private $manager;

    /**
     * Binder constructor.
     * @param $navManager
     */
    public function __construct($navManager)
    {
        $this->manager = $navManager;
    }


    public function startBattle($user1,$user2){
        $this->manager->changeScreen('game');
        $this->manager->bind("PLAYER_1_NAME", $user1);
        $this->manager->bind("PLAYER_2_NAME", $user2);
//        $this->manager->bind("PLAYER_1_HEALTH", $user1->name);
//        $this->manager->bind("PLAYER_2_HEALTH", $user2->name);
        $this->manager->render();
    }
//    public function startBattle($user1,$user2){
//        $this->manager->changeScreen('game');
//        $this->manager->bind("PLAYER_1_NAME", $user1->name);
//        $this->manager->bind("PLAYER_2_NAME", $user2->name);
//        $this->manager->bind("PLAYER_1_HEALTH", $user1->name);
//        $this->manager->bind("PLAYER_2_HEALTH", $user2->name);
//        $this->manager->render();
//    }

    public function startWaitPlayer($userName1){
        $this->manager->changeScreen('waitPlayer');
        $this->manager->bind("USER_NAME", $userName1);
        $this->manager->render();
    }
}