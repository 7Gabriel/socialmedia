<?php

    class User {
        protected $pdo;

        function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        public function checkInput($var){
            $var = htmlspecialchars($var);
            $var = trim($var);
            $var = stripslashes($var);
            return $var;
        }

        public function login($email, $password){
            $stmt = $this->pdo->prepare("SELECT `user_id` from `users` where `email` = :email and `password` = :password");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();

            if($count > 0){
                $_SESSION['user_id'] = $user->user_id;
                header('Location: home.php');
            }else {
                return false;
            }
        }
        
        public function userData($user_id){
            $stmt = $this->pdo->prepare("SELECT * from `users` where `user_id` = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        }


        public function logout(){
            $_SESSION = array();
            session_destroy();
            header('Location: ../index.php');
        }

        public function checkEmail($email){
            $stmt = $this->pdo->prepare("SELECT `email` from `users` where `email` = :email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $count = $stmt->rowCount();
            return $count > 0 ? true : false;
            
        }

        public function register($email, $screenName, $password){
            $passwordHash = md5($password);
	        $stmt = $this->pdo->prepare("INSERT INTO `users` (`username`, `email`, `password`, `screenName`, `profileImage`, `profileCover`) VALUES (:screenName, :email, :passwordHash, :screenName, 'assets/images/defaultprofileimage.png', 'assets/images/defaultCoverImage.png')");
	        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
 	        $stmt->bindParam(":passwordHash", $passwordHash, PDO::PARAM_STR);
	        $stmt->bindParam(":screenName", $screenName, PDO::PARAM_STR);
	        $stmt->execute();

	        $user_id = $this->pdo->lastInsertId();
	        $_SESSION['user_id'] = $user_id;
        }
    }


 


?>