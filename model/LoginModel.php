<?php

namespace model;

class LoginModel {
    
    private static $username = "Admin";
    private static $password = "Password";
    private static $loggedIn;

    public function CheckUserCredential($User) {
        
        return $User->getUsername() == self::$username && $User->getPassword() == self::$password;
    }

    public function Login($User) {
        
        $_SESSION[self::$loggedIn] = $this->CheckUserCredential($User);
    }

    public function Logout() {
        
        $_SESSION[self::$loggedIn] = false;
    }

    public function UserLoggedIn() {
        
        if (empty($_SESSION[self::$loggedIn])) {
            
            return false;
        } 
        else 
        {
            return $_SESSION[self::$loggedIn];
        }

    }
    
}