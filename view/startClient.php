<?php
require_once("includeConst.php");

$register = "./res/html/registration.html";
$manager = new NavigationManager($register);
$manager->putScreen('register', $register);

$manager->renderBy('register');
