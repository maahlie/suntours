<?php

class User {

    public $SqlCommands;

    public function __construct()
    {
        $this->SqlCommands = new SqlCommands();
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

            public function enterReg($email, $phoneNumber, $firstName, $surName, $username, $address, $postalCode, $passwd2, $passwd3){
        
                    $this->emailCheck($email);
                    $this->usernCheck($username);

                   $sql = "INSERT INTO users (username, email, passwrd, phoneNumber, firstName, surName, address, postalCode) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
           
                   $stmt = $this->SqlCommands->pdo->prepare($sql);
                        
                   if ($stmt) {
                       $params = [$username, $email, $passwd2, $phoneNumber, $firstName, $surName, $address, $postalCode];
                       $stmt->execute($params);
                       $this->confMail($email, "test", "test");
                    }                   
            }

            public function userPassCheck($username, $passwrd){

                $this->SqlCommands->connectDB();

                $sql = "SELECT username, passwrd FROM users WHERE username = ? AND passwrd = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$username, $passwrd];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($username == $result['username'] && $passwrd == $result['passwrd']){
                        $correct = true;
                        return $correct;
                    }else{
                        $correct = false;
                        return $correct;
                    }
            }

            public function login($correct, $username){

                if($correct == true){
                        // session_start();
                        $_SESSION['loggedIn']=true;
                        $_SESSION['username']=$username;
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

            public function getActivation($username, $passwrd){
                $this->SqlCommands->connectDB();

                $sql = "SELECT activation FROM users WHERE username = ? AND passwrd = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$username, $passwrd];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
            }
        
}           
?>