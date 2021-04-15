<?php
require_once("include_const.php");

$register = "./res/html/registration.html";
$manager = new NavigationManager($register);
$manager->putScreen('register', $register);

$manager->renderBy('register');
