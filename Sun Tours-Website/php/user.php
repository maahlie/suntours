<?php

class User {

    public $SqlCommands;
    public $hash;

    public function __construct()
    {
        $this->SqlCommands = new SqlCommands();
        $this->hash;
    }
        //primary key moet auto increment zijn!!!! :)

            private function emailCheck($email) {
                //haalt de emails op
                $this->SqlCommands->connectDB();
                $result = $this->SqlCommands->selectFrom("email", "users");

                //checkt de emails tegen de ingevoerde email
                    for($i = 0; $i < count($result); $i++){
                        if($email == $result[$i][0]){
                            $text = "email bestaat al!";
                            exit($text);
                        } 
                    }
            }

            private function usernCheck($username) {
                //haalt de username op
                $this->SqlCommands->connectDB();
                $result = $this->SqlCommands->selectFrom("username", "users");

                //checkt de usernames tegen de ingevoerde username
                    for($i = 0; $i < count($result); $i++){
                        if($username == $result[$i][0]){
                            $text = "username bestaat al!";
                            exit($text);
                        }
                    }
            }

            private function confMail($targetEmail,$mailBody,$mailSubject)
            {
                $mail = new Mail($mailBody, $mailSubject, $targetEmail);
                $mail->email();
            }

            public function enterReg($email, $phoneNumber, $firstName, $surName, $username, $address, $postalCode, $passwd2, $passwd3, $hashed){
        

                $passwrd_new1 = $_POST['passwd2'];
                $passwrd_new2 = $_POST['passwd3'];

                $this->hash = password_hash($passwrd_new1, PASSWORD_DEFAULT);
                $hashed = $this->hash;

                    $this->emailCheck($email);
                    $this->usernCheck($username);
                    //    $username = trim(htmlentities($username));
                    //    $email = trim(htmlentities($email));
                    //    $passwd2 = trim(htmlentities($passwd2));
                    //    $firstName = trim(htmlentities($firstName));
                    //    $surName = trim(htmlentities($_POST['surName']));
                    //    $phoneNumber = trim(htmlentities($_POST['phonenumber']));

                   $sql = "INSERT INTO users (username, email, passwrd, phoneNumber, firstName, surName, address, postalCode) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
           
                   $stmt = $this->SqlCommands->pdo->prepare($sql);
                        
                   if ($stmt) {
                       $params = [$username, $email, $hashed, $phoneNumber, $firstName, $surName, $address, $postalCode];
                       $stmt->execute($params);
                       return $hashed;
                       //$this->confMail($email);
                    }                   
            }

            public function login($username, $passwrd){

                $passwdLogin = $_POST['passwdLogin'];
                $usernLogin = $_POST['usernLogin'];

                $this->SqlCommands->connectDB();
                $this->hash;
                $hashed = $this->hash;

                $sql = "SELECT username, passwrd FROM users WHERE username = ?";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$username];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if($usernLogin == $result['username']) {
                            password_verify($hashed, $passwdLogin);
                            // session_start();
                            $_SESSION['loggedIn']=true;
                            $_SESSION['username']=$result["username"];
                        } else {
                            $_SESSION = [];
                            session_destroy();
                        }
                    }

            public function contact($email,$mailBody,$mailSubject,$contactName)
            {
                $targetEmail = 'SunTours.devOps@hotmail.com';
                $completeBody = "Deze email is verzonden door email addres: " . $email . "<br/>" . "Naam: ". $contactName . "<br/>" . $mailBody;
                $this->confMail($targetEmail,$completeBody,$mailSubject);
                exit('Uw Bericht is succelvol verzonden en wordt zo snel mogenlijk in behandeling genomen.');
            }

            public function logout(){
                
                $_SESSION[] = array();

                // destroy de sessie
                session_destroy();
            }
        
}           
?>