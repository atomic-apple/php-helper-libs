<?php

class User extends AppObject {
	public $userID;
	public $userName;
	public $userPwd;
	public $userEmail;
	public $companyID;
	public $userAuth;

	protected static $dbIndex = "userID";
	protected static $dbTable = "users";
	protected static $dbTableFields = array(
		'userID',
		'userName',
		'userPwd',
		'userEmail',
		'companyID',
		'userAuth');
	protected $dbIndexVal;

	public function __toString() {
		$humanReadable = "<div>
		ID: {$this->userID}<br />
		User Name: {$this->userName}<br />
		Company ID: {$this->companyID}<br />
		Email: {$this->userEmail}<br /><br />
		</div>";
		return $humanReadable;
	}

	public static function verifyUser( $uname, $pwd ) {
		global $database;

		$username = $database->escapeString( $uname );
		$password = $database->escapeString( $pwd );

		$sql = "SELECT * FROM " . self::$dbTable . " WHERE `userName` = ";
		$sql .= "`{$userName}` LIMIT 1";

		// Fetches an Array of instantiated objects of the User class with matching userName's
		$resultArray = self::findByQuery( $sql );

		if( $this->passwordMethod( $password, $database->escapeString( $resultArray['userPwd'] ) ) ) {
			return array_shift( $resultArray );
		} else {
			return false;
		}
	}

	private function passwordMethod( $pwd, $dbDataPwd ) {
		return (password_hash( $pwd, $dbDataPwd ) );
	}

	public function checkAuth( $requiredAuth ) {
		return ( $this->userAuth < $requiredAuth ) ? false : true;
	}

}

?>
