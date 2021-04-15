<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

//require_once("controller/ControllerGame.php");
require_once("model/db/BattleDb.php");
require_once("view/NavigationManager.php");
require_once("view/binder.php");
require_once("view/../controller/ControllerRegister.php");
require_once("view/../controller/ControllerGame.php");
require_once("view/../model/db/Model.php");
require_once("view/../model/db/User.php");
require_once("view/../model/db/BattleDb.php");
require_once("view/../model/db/UserDB.php");
require_once("view/../model/db/PlayerWaitDb.php");
require_once("view/../model/db/DatabaseConnection.php");
//require_once("../model/");
//require_once("../model/data_class/");
require_once("view/../model/data_class/Battle.php");
require_once("view/../model/data_class/BattleCard.php");
require_once("view/../model/data_class/Heroes.php");
require_once("view/../model/data_class/Player.php");


$controllerGame = new ControllerGame(null, null);

if (isset($_POST['json'])) {
    if (isset($_POST['json']['card'])) {
        $controllerGame->addCard($_POST['json']['player'], $_POST['json']['card']);
    } elseif (isset($_POST['json']['player'])) {
        $controller = new ControllerGame(null, null);
        $controller->checkCardByUser('kate');
    }
}




