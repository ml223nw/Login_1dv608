<?php

namespace view;

use model\User;

require_once("./model/LoginModel.php");


class LoginView {
	
	private $LoginModel;
	
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $message = "MessageSessionVariable";
	private static $username = "UsernameSessionVariable";


	public function __construct(\model\LoginModel $model) {
		
		$this->LoginModel = $model;
	}

	// Returns error messages if the username and/or password is not valid.

	public function TryLogin($User) {
		
		if (empty($_POST[self::$name])) {
			
			return "Username is missing";
		}
		
		if (empty($_POST[self::$password])) {
			
			return "Password is missing";
		}	
		
		if (!$this->LoginModel->CheckUserCredential($User)) {
			
			return "Wrong name or password";
		}	
		else 
		{
			return '';
		}
	
	}
	
	// Return strings from the users input.
	
	public function GetUser() {
		
		$User = '';
		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
		
			$User = new User($_POST[self::$name], $_POST[self::$password]);
		}
		else
		{
			$User = new User('', '');
		}
			return $User;
	}

	// Return messages. Only displays once.

	private function GetMessage() {
		
		if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION[self::$message])) {
			
			$ret = $_SESSION[self::$message];
			unset($_SESSION[self::$message]);
			return $ret;
		}

	}

	//Return true if the user wants to login.

	public function UserLogin() {
		
		return isset($_POST[self::$login]);
	}
	
	// Sets message on a successful login. Else, returns error message.

	public function LoginViewMessage() {
		
		$message = ($this->TryLogin($this->GetUser()));
		
		if (empty($message)) {
			
			$message = "Welcome";
		}
			$this->SetMessage($message);
	}

	//Return true if the user wants to logout.

	public function UserLogout() {
		
		return isset($_POST[self::$logout]);
	}

	// Sets message on logout.

	public function LogoutViewMessage() {
		
		$this->SetMessage("Bye bye!");
	}

	// Sets a message.

	private function SetMessage($message) {
		
		if ($_POST) {
			
			$_SESSION[self::$message] = $message;
            header("Location: " . $_SERVER['REQUEST_URI']);
		}
		
	}
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		
		$message = '';
		
		if ($this->LoginModel->UserLoggedIn()) {
			
			$message = $this->GetMessage();
			$response = $this->generateLogoutButtonHTML($message);
		}
		else
		{
			$message = $this->GetMessage();
			$response = $this->generateLoginFormHTML($message);
		}

		return $response;
	}
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

}