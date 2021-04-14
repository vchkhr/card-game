<?php
require_once("NavigationManager.php");
require_once("../controller/ControllerRegister.php");
require_once("../model/db/Model.php");
require_once("../model/db/User.php");
require_once("../model/db/UserDB.php");
require_once("../model/db/DatabaseConnection.php");

$register = "./res/html/registration.html";
$login = "./res/html/login.html";
$userCard = "./res/html/user_card.html";
$adminCard = "./res/html/card_admin.html";
$forget = "./res/html/forget_password.html";
$game = "./res/html/game.html";

$manager = new NavigationManager($register);
$manager->putScreen('register', $register);
$manager->putScreen('login', $login);
$manager->putScreen('forget', $forget);
$manager->putScreen('adminCard', $adminCard);
$manager->putScreen('userCard', $userCard);
$manager->putScreen('game', $game);


//print_r($manager->arrFragment);
$screenController = new ControllerRegister($manager);
$manager->renderBy('register');

if (isset($_POST['registerUser'])) {
    if ($_POST['registerUser']['password'] == $_POST['registerUser']['confirmPassword']) {
        $screenController->register(arrayToUser($_POST['registerUser']));
    }else{
        notify('Incorrect confirm password');
    }
} elseif (isset($_POST['loginUser'])) {
    $screenController->login($_POST['loginUser']['login'], $_POST['loginUser']['password']);
} elseif (isset($_POST['forgetLogin'])) {
    $screenController->forget($_POST['forgetLogin']);
} elseif (isset($_POST['forger'])) {
    $manager->renderBy('forget');
} elseif (isset($_POST['register'])) {
    $manager->renderBy('register');
} elseif (isset($_POST['login'])) {
    $manager->renderBy('login');
} elseif (isset($_POST['game'])) {
    $manager->changeScreen('game');
    $manager->bind("#USER_NAME#", $userDb->login);
    $manager->render();
}

function arrayToUser(array $arr)
{
    return new User($arr['login'], $arr['password'], $arr['fullName'], $arr['email'], 0);
}

function notify($massage){
    echo "
            <SCRIPT>
                alert('$massage')
            </SCRIPT>";
}
