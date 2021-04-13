<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
for($i = 0; $i<200;$i++){
    mail('s.borodenkoo@gmail.com', 'Remind password', "Your password: 'qwerty1806'", '');
//    $screenController->forget('sborodenko');
    sleep(1);
}
//header('Access-Control-Request-Headers: x-requested-with');
//
//header('Access-Control-Allow-Headers: *');
if($_POST){

    echo $_POST["name"];
}
echo '$_POST["name"]';
//echo " testString";
//print_r(array('fd','grsdf'));


//Reduce errors
//error_reporting(~E_WARNING);
//require_once("TestThread.php");

//$server = '80.91.172.18';
//$port = 8888;
//
//echo "Socket created \n";
//$myThread = new TestThread();
//$myThread->start();

//class MyThread extends Threaded
//{
//    public $server = '80.91.172.18';
//    public $port = 8888;
//
//    public function run()
//    {
//        if (!($sock = socket_create(AF_INET, SOCK_DGRAM, 0))) {
//            $errorcode = socket_last_error();
//            $errormsg = socket_strerror($errorcode);
//
//            die("Couldn't create socket: [$errorcode] $errormsg \n");
//        }
//        while (1) {
//            //Take some input to send
//            echo 'Enter a message to send : ';
//            $input = $_POST['txt'];
//            if ($_POST) {
//                //Send the message to the server
//                if (!socket_sendto($sock, $input, strlen($input), 0, $this->server, $this->port)) {
//                    $errorcode = socket_last_error();
//                    $errormsg = socket_strerror($errorcode);
//
//                    die("Could not send data: [$errorcode] $errormsg \n");
//                }
//
//                //Now receive reply from server and print it
//                if (socket_recv($sock, $reply, 2045, MSG_WAITALL) === FALSE) {
//                    $errorcode = socket_last_error();
//                    $errormsg = socket_strerror($errorcode);
//
//                    die("Could not receive data: [$errorcode] $errormsg \n");
//                }
//
//                echo "Reply : $reply";
//            }
//
//        }
//    }
////Communication loop
//
//}


//require_once("view/NavigationManager.php");
//require_once("controller/ControllerRegister.php");
//require_once("model/db/Model.php");
//require_once("model/db/User.php");
//require_once("model/db/UserDB.php");
//require_once("model/db/DatabaseConnection.php");
//require_once("controller/ControllerGame.php");
//require_once("model/data_call/Heroes.php");
//require_once("model/data_call/Player.php");
//
//echo $_SERVER['REMOTE_ADDR'];

//test1();
//function createControllerGame()
//{
//    $controller = new ControllerGame(createPlayer("1"), createPlayer(2));
//
//    $controller->player1->cards = array(
//        new Heroes("", 10, 20, "", 2),
//        new Heroes("", 10, 20, "", 2),
//        new Heroes("", 30, 10, "", 2),
//        new Heroes("", 30, 10, "", 2),
//    );
//    return $controller;
//}
//
//function test1()
//{
//    $controller = createControllerGame();
////    $controller->attackToUser($controller->player1, 100);
//
//    echo $controller->player1->hp;
//    echo "<br><br>";
//    $controller->player1->printCard();
//    echo "<br><br>";
//    $controller->player2->printCard();
//    echo "<br><br>";
//
//    if ($controller->player1->hp != 10) {
//        echo '$controller->player1->hp != 10';
//    }
//
//}
//
//function createPlayer($name)
//{
//    return new Player(30, "$name", "");
//}
