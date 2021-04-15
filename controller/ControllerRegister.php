<?php

class ControllerRegister
{
    private $manager;

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
        } catch (Exception $e) {
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
                    $this->manager->bind("USER_NAME", $userDb->login);
                    $this->manager->render();
                } else {
                    $this->manager->changeScreen('userCard');
                    $this->manager->bind("USER_NAME", $userDb->login);
                    $this->manager->bind("PROFILE_IMAGE", $userDb->img);
                    $this->manager->render();
                }
            }
        } else {
            $this->notify('Unknown user');
        }
    }

    public function loadUser($login)
    {
        $userDb = new UserDB();
        $userDb->login = $login;

        if (!$userDb->isEmpty()) {
            $userDb->find($userDb->login);
            $this->manager->changeScreen('userCard');
            $this->manager->bind("USER_NAME", $userDb->login);
            $this->manager->bind("PROFILE_IMAGE", $userDb->img);
            $this->manager->render();
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
        } catch (Exception $e) {
            $this->notify('Unknown user');
        }

        mail($userDb->email_address, 'Remind password', "Your password: '$userDb->password'", '');
    }

    function isPasswordCorrect($password1, $password2)
    {
        return $password1 == $password2;
    }

    private function notify($massage)
    {
        echo "  
            <SCRIPT>
                alert('$massage')
            </SCRIPT>";
    }

    public function getSearchUsers()
    {
        $db = new PlayerWaitDb();
        $listUser = $db->getUsers();
        $strUl = '';

        foreach ($listUser as $user) {
            $strUl .= "$user";
        }
    }

    public function startBattle($userLogin)
    {
        $db = new PlayerWaitDb();
        $listUser = $db->getUsers();
        $dbBattle = new BattleDb();
        $idBattle = -1;

        foreach ($listUser as $user) {
            if ($user['loginUser'] != $user) {
                try {
                    $idBattle = $dbBattle->startBattle($userLogin, $user['loginUser']);
                    $db->removeUser($userLogin);
                    $db->removeUser($user['loginUser']);

                    return true;
                } catch (Exception $e) {

                }
            } else {
                $idBattle = -2;
            }
        }

        if ($idBattle == -1) {
            $db->addUser($userLogin, '');
        }

        return false;
    }

    public function isWait($userLogin)
    {
        $db = new PlayerWaitDb();
        $listUser = $db->getUsers();

        foreach ($listUser as $user) {
            if ($userLogin == $user['loginUser']) {
                return true;
            }
        }

        return false;
    }

    public function getUserInBattleByUser($loginUser)
    {
        $dbBattle = new BattleDb();
        $battle = $dbBattle->getBattleById($dbBattle->getBattleByPlayer($loginUser));

        if ($battle->player1 != $loginUser)
            return $battle->player1;
        else
            return $battle->player2;
    }

    public function createRandUser($login)
    {
        $dbBattle = new BattleDb();
        $id = $dbBattle->getBattleByPlayer($login);
        $battle = $dbBattle->getBattleById($id);

        return $battle->player1;
    }
}
