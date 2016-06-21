<?php
/*
	This class DEPENDS upon the user library class for it's user API.  Without the inclusion
	of this userLIB then some of the functionality of this Session class will be lost.

	In particular the dependency on the userClass methods to determine if the user exists
	in the user DB and to establish the userID of this user for use in the SESSION_VARS.

*/

class Session {

	private $signedIn = false;
	public $userID;
	public $message;

	function __construct() {
		session_start();
		$this->checkLogin();
		$this->checkMessage();
	}

	public function isSignedIn() {
		return $this->signedIn();
	}

	public function logIn( $user ) {
		if( $user ) {
			$this->userID = $_SESSION['userID'] = $user->userID;
		}
		$userResult = $user->findByID( $_SESSION['userID'] );
		$_SESSION['userName'] = $userResult->userName;
		$_SESSION['auth'] = $result->authCode;
		$this->signedIn = true;
	}

	public function logOut() {
		unset( $_SESSION['userID'] );
		unset( $_SESSION['userName'] );
		unset( $_SESSION['auth'] );
		unset( $this->userID );
		$this->signedIn = false;
	}

	private function checkLogin() {
		if( isset( $_SESSION['userID'] ) ) {
			$this->userID = $_SESSION['userID'];
			$this->signedIn = true;
		} else {
			unset( $this->userID );
			$this->signedIn = false;
		}
	}

	public function message( $msg="" ) {
		if( !empty( $msg ) ) {
			$_SESSION['message'] = $msg;
		} else {
			return $this->message;
		}
	}

	public function checkMessage() {
		if( isset( $_SESSION['message'] ) ) {
			$this->message = $_SESSION['message'];
			unset( $_SESSION['message'] );
		} else {
			$this->message = "";
		}
	}

}

$session = new Session();

?>
