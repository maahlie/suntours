<?php
class User {

    public $SqlCommands;
    public $showMsg;
    public $showMsgEmail;

    public function __construct()
    {
        $this->SqlCommands = new SqlCommands();
        $this->showMsg = false;
        $this->showMsgEmail = false;
    }
        //primary key moet auto increment zijn!!!! :)
    
            private function passwdCheck() {
                //checkt of de ingevoerde wachtwoorden hetzelfde zijn
                if(isset($_POST['passwd2']) && isset($_POST['passwd3'])){
                    if($_POST['passwd2'] != $_POST['passwd3']){
                        $this->showMsg = true;
                        if($this->showMsg==true){

                            $message="wachtwoorden matchen niet!";
                  
                            echo "<script type='text/javascript'>alert('$message');</script>";
                  
                          }
                          header("Location: ../aanmelden.php", TRUE, 303);

                        return $this->showMsg;
                        exit;
                    } else {
                        $this->showMsg = false;
                        return $this->showMsg;
                    }
                }
            }

            private function emailCheck() {
                //haalt de emails op
                $this->SqlCommands->connectDB();
                $result = $this->SqlCommands->selectAllFrom("email", "users");

                //checkt de emails tegen de ingevoerde email
                if(isset($_POST['email'])){
                    for($i = 0; $i < count($result); $i++){
                        if($_POST['email'] == $result[$i][0]){
                            $this->showMsgEmail = true;

                            // header("Location: ../aanmelden.php", TRUE, 303);
        

                            return $this->showMsgEmail;
                            exit;
                        } else {
                            $this->showMsgEmail = false;
                            return $this->showMsgEmail;
                        }
                    }
                }
            }
            // email: "email", phoneNum: "phonenumber", firstName: "firstName", surName: "surName", userName: "usern", address: "address", postalCode: "postalCode", passwd1: "passwd2", passwd2: "passwd3"
            public function enterReg($email, $phoneNumber, $firstName, $surName, $username, $address, $postalCode, $passwd2, $passwd3){
                // if (isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['firstName'])
                // && isset($_POST['surName']) && isset($_POST['usern']) && isset($_POST['passwd2']) && isset($_POST['passwd3'])){
        
                    // $this->passwdCheck();
                    // $this->emailCheck();

                    // if($this->showMsg == false && $this->showMsgEmail == false){

                    // echo $this->showMsg;

                //    $username = trim(htmlentities($_POST['usern']));
                //    $email = trim(htmlentities($_POST['email']));
                //    $passwrd = trim(htmlentities($_POST['passwd2']));
                //    $firstName = trim(htmlentities($_POST['firstName']));
                //    $surName = trim(htmlentities($_POST['surName']));
                //    $phoneNumber = trim(htmlentities($_POST['phonenumber']));

                   $sql = "INSERT INTO users (username, email, passwrd, phoneNumber, firstName, surName, address, postalCode) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
           
                   $stmt = $this->SqlCommands->pdo->prepare($sql);
                        
                   if ($stmt) {
                       $params = [$username, $email, $passwd2, $phoneNumber, $firstName, $surName, $address, $postalCode];
                       $stmt->execute($params);
                    }
                    // header("Location: aanmelden.php", TRUE, 303);

                }
               
            }


            // if (isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['firstName']) && isset($_POST['surName']) && isset($_POST['usern']) && isset($_POST['passwd2']) && isset($_POST['passwd3'])) 
            // {

            // $username = trim(htmlentities($_POST['usern']));
            // $email = trim(htmlentities($_POST['email']));
            // $passwrd = trim(htmlentities($_POST['passwd2']));
            // $passwordCtrl = trim(htmlentities($_POST['passwd3']));
            // $firstName = trim(htmlentities($_POST['firstName']));
            // $surName = trim(htmlentities($_POST['surName']));
            // $phoneNumber = trim(htmlentities($_POST['phonenumber']));
    
            // $sql = "INSERT INTO users (username, email, passwrd, phoneNumber, firstName, surName) VALUES(?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
    
            // $stmt = $SqlCommands->pdo->prepare($sql);
    
            // if ($stmt) {
            //     $params = [$username, $email, $passwrd, $phoneNumber, $firstName, $surName];
            //     $stmt->execute($params);
            //     echo $username;
            // }
    
            // header("Location: ../aanmelden.php", TRUE, 303);
        

?>