<?php
	
	/**
	 * 
	 */
	class DbOperations
	{
		private $con;
		
		function __construct()
		{
			require_once dirname(__FILE__).'/DbConnect.php';
			$db = new DbConnect();
			$this->con = $db->connect();
		}

		public function userLogin($username, $pass){
		//	$password = md5($pass);
			$stmt = $this->con->prepare("SELECT * FROM teacher WHERE username = ? AND password = ?");
			$stmt->bind_param("ss", $username, $pass);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		} 

		public function getUserByUsername($username){
			$stmt = $this->con->prepare("SELECT * FROM teacher WHERE username = ?");
			$stmt->bind_param("s", $username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		private function isUserExist($username, $email){
			$stmt = $this->con->prepare("SELECT id FROM teacher WHERE username = ? OR email = ?");
			$stmt->bind_param("ss",$username,$email);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;

		}
	}