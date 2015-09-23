<?php

namespace controller;

require_once("./model/User.php");
require_once("./model/LoginModel.php");
require_once("./view/LoginView.php");

use view;
use model;

class LoginController {
    
    private static $LoginView;
    private static $LoginModel;

    public function __construct(\model\LoginModel $model) {
        
        self::$LoginModel = $model;
        self::$LoginView = new view\LoginView(self::$LoginModel);
    }

    public function LoginState() {
        
        if (self::$LoginView->UserLogin() && !self::$LoginModel->UserLoggedIn()) {
            
            self::$LoginView->LoginViewMessage();
            self::$LoginModel->Login(self::$LoginView->GetUser());
        }
        
        if (self::$LoginView->UserLogout() && self::$LoginModel->UserLoggedIn()) {
            
            self::$LoginView->LogoutViewMessage();
            self::$LoginModel->Logout();
        }
        
    }

    public function LoginView() {
        
        return self::$LoginView;
    }
    
}
