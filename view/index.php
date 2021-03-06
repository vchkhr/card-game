<?php

require_once("includeConst.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$register = "./res/html/registration.html";
$login = "./res/html/login.html";
$userCard = "./res/html/profile.html";
$adminCard = "./res/html/profile.html";
$forget = "./res/html/forgotPassword.html";
$game = "./res/html/game.html";
$waitPlayer = "./res/html/waitPlayer.html";

// require_once("../model/data_class/");

// $playerWaitDb = new PlayerWaitDb();
// $playerWaitDb->removeUser('User1');
// $playerWaitDb->addUser('User1','User1');
// $playerWaitDb->addUser('User4','User1');
// $playerWaitDb->removeUser('User1');
// $playerWaitDb->removeUser('User2');
// $playerWaitDb->removeUser('User3');
// $playerWaitDb->removeUser('User4');
// print_r($playerWaitDb->getUsers());
// print_r();
// $cardDb = new BattleDb();
// $cardDb->finishBattle(7);

$manager = new NavigationManager($register);
$manager->putScreen('register', $register);
$manager->putScreen('login', $login);
$manager->putScreen('forget', $forget);
$manager->putScreen('adminCard', $adminCard);
$manager->putScreen('userCard', $userCard);
$manager->putScreen('game', $game);
$manager->putScreen('waitPlayer', $waitPlayer);

$binder = new Binder($manager);

$screenController = new ControllerRegister($manager);
$controllerGame = new ControllerGame(null, null);

// print_r($manager->arrFragment);
// $manager->renderBy('register');
// $binder->startBattle("User1", 'User2');

if (isset($_POST['registerUser'])) {
    if ($_POST['registerUser']['password'] == $_POST['registerUser']['confirmPassword']) {
        $screenController->register(arrayToUser($_POST['registerUser']));
    } else {
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
} elseif (isset($_POST['removeWaitUser'])) {
    $db = new PlayerWaitDb();
    $db->removeUser($_POST['removeWaitUserLogin']);
    $screenController->loadUser($_POST['removeWaitUserLogin']);

//    $manager->renderBy('login');
} elseif (isset($_POST['checkSearcherUser'])) {
    $loginUser = $_POST['checkSearcherUser'];
    
    if (!$screenController->isWait($loginUser)) {
        $player2 = $screenController->getUserInBattleByUser($loginUser);
        $binder->startBattle("$loginUser", $player2);
    } else
        $binder->startWaitPlayer($_POST['removeWaitUserLogin']);
} elseif (isset($_POST['game'])) {
    if ($screenController->startBattle($_POST['startGameLogin'])) {
        $loginUser = $_POST['startGameLogin'];
        $player2 = $screenController->getUserInBattleByUser($loginUser);
        $userDb = new UserDB();
        $userDb->login = $loginUser;
        $userDb->find($loginUser);
        $userDb->img = $_POST['profileImage'];
        $userDb->update();

        $binder->startBattle($loginUser, $player2);
        // $binder->startBattle("kate", "User3");
    } else {
        $binder->startWaitPlayer($_POST['startGameLogin']);
    }
} elseif (isset($_POST['json'])) {
    if (isset($_POST['json']['card'])) {
        $controllerGame->addCard($_POST['json']['player'], $_POST['json']['card']);
    } elseif (isset($_POST['json']['player'])) {
        $loginUser = $_POST['json']['player'];
        $controller = new ControllerGame(null, null);
        $controller->checkCardByUser($loginUser);
    }
}
if (isset($_POST['json']['whoIsFirst'])) {
    echo $screenController->createRandUser($_POST['json']['whoIsFirst']);
}
if (isset($_POST['json']['gameOver'])){
    $controllerGame->finishBattle($_POST['json']['gameOver']);
}
if (isset($_POST['exitToMainLogin'])){
    $screenController->loadUser($_POST['exitToMainLogin']);

    // $manager->changeScreen('userCard');
    // $this->manager->bind("USER_NAME", $_POST['exitToMainLogin']);
    // $this->manager->render();
}

function arrayToUser(array $arr)
{
    return new User($arr['login'], $arr['password'], $arr['fullName'], $arr['email'], 0);
}

function notify($massage)
{
    echo "
            <SCRIPT>
                alert('$massage')
            </SCRIPT>";
}
