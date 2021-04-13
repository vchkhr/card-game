<?php


class TestThread extends Thread
{
    public $server = '80.91.172.18';
    public $port = 8888;

    public function run()
    {
        if (!($sock = socket_create(AF_INET, SOCK_DGRAM, 0))) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Couldn't create socket: [$errorcode] $errormsg \n");
        }
        while (1) {
            //Take some input to send
            echo 'Enter a message to send : ';
            $input = $_POST['txt'];
            if ($_POST) {
                //Send the message to the server
                if (!socket_sendto($sock, $input, strlen($input), 0, $this->server, $this->port)) {
                    $errorcode = socket_last_error();
                    $errormsg = socket_strerror($errorcode);

                    die("Could not send data: [$errorcode] $errormsg \n");
                }

                //Now receive reply from server and print it
                if (socket_recv($sock, $reply, 2045, MSG_WAITALL) === FALSE) {
                    $errorcode = socket_last_error();
                    $errormsg = socket_strerror($errorcode);

                    die("Could not receive data: [$errorcode] $errormsg \n");
                }

                echo "Reply : $reply";
            }

        }
    }
//Communication loop

}
