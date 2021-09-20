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
                $result = $this->SqlCommands->selectAllFrom("email", "users");

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
                $result = $this->SqlCommands->selectAllFrom("username", "users");

                //checkt de usernames tegen de ingevoerde username
                    for($i = 0; $i < count($result); $i++){
                        if($username == $result[$i][0]){
                            $text = "username bestaat al!";
                            exit($text);
                        }
                    }
            }

            public function enterReg($email, $phoneNumber, $firstName, $surName, $username, $address, $postalCode, $passwd2, $passwd3){
        
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
                       $params = [$username, $email, $passwd2, $phoneNumber, $firstName, $surName, $address, $postalCode];
                       $stmt->execute($params);
                    }
            }

            public function login($username, $passwrd){

                $this->SqlCommands->connectDB();

                $sql = "SELECT username, passwrd FROM users WHERE username = ? AND passwrd = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$username, $passwrd];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($username == $result['username'] && $passwrd == $result['passwrd']){
                        // session_start();
                        $_SESSION['loggedIn']=true;
                        $_SESSION['username']=$result["username"];
                    }
            }
            
        
}
?>