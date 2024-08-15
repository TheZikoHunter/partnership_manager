<?php
try{
    require_once ABSOLUTE_PATH . '/classes/Database.php';
}catch(Throwable $t){
    echo "Problem in my user.php";
}

class User{
    public function insertUser(string $username, string $password){
        $db = Database::getInstance() -> getConnexion();
        /**
         * Verify if the admin email is used with the correct password
         */
        $user = $db -> query("SELECT username FROM User WHERE username = '$username'") -> fetch(PDO::FETCH_ASSOC);
        if(!($user)){
            
			try{
				$query = $db -> prepare("INSERT INTO User (email, username, password, admin) VALUES ('" . $this -> adminEmail() ."', ". $db -> quote($username) . ", '".
				password_hash($password, PASSWORD_DEFAULT)."', '0')");
				$query -> execute();
			}catch(Throwable $t){
				echo 'problem in function insertUser'
				. $t;
			}
            
	}
    }
    public function insertAdmin(string $email, string $username, string $password){
        $db = Database::getInstance() -> getConnexion();
        /**
         * Verify if the admin email is used with the correct password
         */
        
		try{
			$admin = $db -> query("SELECT username FROM User WHERE username = '$username'") -> fetch(PDO::FETCH_ASSOC);
        if(!($admin)){
            $query = $db -> prepare("INSERT INTO User (email, username, password, admin) VALUES ('$email', '$username', '".password_hash($password, PASSWORD_DEFAULT)."', '1')");
            $query -> execute();
            $_SESSION['loged'] = $this -> userType($username);
            header('Location:/');
			exit;
        }
		}catch(Throwable $t){
			echo 'problem in insertAdmin';
		}
    }
    public function listUsers(){
        $db = Database::getInstance() -> getConnexion();
        $users = $db -> query("SELECT * FROM User") -> fetchAll(PDO::FETCH_ASSOC);
	return $users;

    }
    public function logUser(string $username, string $password){
        $db = Database::getInstance() -> getConnexion();

        $users = $db -> query("SELECT username, password FROM User") -> fetchAll(PDO::FETCH_ASSOC);
        foreach($users as $user){
            if($user['username'] === $username && password_verify($password, $user['password'])){
                $_SESSION['loged'] = $this -> userType($username);
				header('Location:/');
				exit;
            }
	}

    }
	
	private function userType(string $username):string
	{
		$db = Database::getInstance() -> getConnexion();
		$type = $db -> query("SELECT admin FROM User WHERE username='$username'") -> fetch(PDO::FETCH_ASSOC);
		return $type['admin'];
	}
	
	private function adminEmail():string
	{
		$db = Database::getInstance() -> getConnexion();
		$mail = $db -> query("SELECT email FROM User WHERE admin = '1'") -> fetch(PDO::FETCH_ASSOC);
		return $mail['email'];
	}
}
