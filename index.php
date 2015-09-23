<?php

// //INCLUDE THE FILES NEEDED...
require_once('model/LoginModel.php');
require_once('view/LoginView.php');
require_once('view/LayoutView.php');
require_once('view/DateTimeView.php');
require_once('controller/LoginController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

session_start();

//CREATE OBJECTS OF THE VIEWS
$LoginModel = new \model\LoginModel();
$LoginController = new \controller\LoginController($LoginModel);

$LoginController->LoginState();
$LoginView = $LoginController->LoginView();
$LayoutView = new \view\LayoutView();
$DateTimeView = new \view\DateTimeView();

$LayoutView->render($LoginModel->UserLoggedIn(), $LoginView, $DateTimeView);
