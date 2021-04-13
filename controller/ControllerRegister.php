<?php

class ControllerRegister
{
    private $manager;

    /**
     * ControllerRegister constructor.
     * @param NavigationManager $manager
     */
    public function __construct(NavigationManager $manager)
    {
        $this->manager = $manager;
    }

    public function register(User $user)
    {
        $userDb = new UserDB();
        $userDb->login = $user->login;
        $userDb->password = $user->password;
        $userDb->email_address = $user->email_address;
        $userDb->full_name = $user->full_name;
        try {
            $userDb->insert();
        } catch (Exception $e){
            $this->notify('User already exists');
        }
        $this->notify('User created');
        $this->manager->renderBy('login');
    }

    public function login($login, $password)
    {
        $userDb = new UserDB();
        $userDb->login = $login;
        if (!$userDb->isEmpty()) {
            $userDb->find($userDb->login);
            echo $userDb->password;
            if (!$this->isPasswordCorrect($userDb->password, $password)) {

                $this->notify('Incorrect password');
            } else {
                if ($userDb->isAdmin) {
                    $this->manager->changeScreen('adminCard');
                    $this->manager->bind("#USER_NAME#",$userDb->login);
                    $this->manager->render();
                } else {
                    $this->manager->changeScreen('userCard');
                    $this->manager->bind("#USER_NAME#",$userDb->login);
                    $this->manager->render();
                }
            }
        } else {
            $this->notify('Unknown user');
        }
    }

    public function forget($email)
    {
        $userDb = new UserDB();
        $login = $email;
        $userDb->login = $login;
        try {
            $userDb->find($login);
        }catch (Exception $e){
            $this->notify('Unknown user');
        }
        mail($userDb->email_address, 'Remind password', "Your password: '$userDb->password'", '');

    }

    function isPasswordCorrect($password1, $password2)
    {
        return $password1 == $password2;
    }

    private function notify($massage){
        echo "  
            <SCRIPT>
                alert('$massage')
            </SCRIPT>";
    }
}
