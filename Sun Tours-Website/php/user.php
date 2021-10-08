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
        

                $passwrd_new1 = $_POST['passwd2'];
                $passwrd_new2 = $_POST['passwd3'];

                $hash = password_hash($passwrd_new1, PASSWORD_DEFAULT);

                    $this->emailCheck($email);
                    $this->usernCheck($username);

                   $sql = "INSERT INTO users (username, email, passwrd, phoneNumber, firstName, surName, address, postalCode) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
           
                   $stmt = $this->SqlCommands->pdo->prepare($sql);
                        
                   if ($stmt) {
                       $params = [$username, $email, $hash, $phoneNumber, $firstName, $surName, $address, $postalCode];
                       $stmt->execute($params);
                       //$this->confMail($email);
                    }                   
            }

            public function login($username, $passwrd){

                $this->SqlCommands->connectDB();
                //$verify = password_verify($hashed, $passwdLogin);

                $sql = "SELECT username, passwrd FROM users WHERE username = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$username];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    $verify = password_verify($passwrd, $result['passwrd']);
                    
                    if($username == $result['username'] && $verify == true) {
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
//enterReview maakt een niewe review aan in de database aan de hand van ingevoerde waardens
public function enterReview($packageId, $score, $reviewSubject, $review, $reccomendation, $username)
{
    //controleerd of de gebruiker is ingelogd.
    if (!isset($_SESSION['username'])){
        exit('log in on een review achter te laten');
    }

    $this->SqlCommands->connectDB();

    // kijkt of een gebruiker al eens een review heeft geschreven.
    $sql = 'SELECT username FROM `review` WHERE `username` = ?';
    $stmt = $this->SqlCommands->pdo->prepare($sql);
    $params = [$username];
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result){
        exit('U kunt maar 1 review achter laten');
    }

    //nieuwe revieuw wordt toe gevoegd aan de database
    $sql = "INSERT INTO review (packageId, score, reviewSubject, review, reccomendation, username) VALUES(?, ?, ?, ?, ?, ?)";
    $stmt = $this->SqlCommands->pdo->prepare($sql);
            
       if ($stmt) {
           $params = [$packageId, $score, $reviewSubject, $review, $reccomendation, $username];
           $stmt->execute($params);
           //$this->confMail($email);
        } 

    $this->showReview();
    exit("Uw review is ingezonden, bedankt voor uw moeite.");
}

//showReview laat de laatste 12 reviews zien op de pagina van de website
public function showReview()
{
    $this->SqlCommands->connectDB();
   
    $sql = "SELECT * FROM review ORDER BY reviewID DESC LIMIT 12";
    $stmt = $this->SqlCommands->pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $this->reviewLength = count($result);
    for ($i = 1; $i < $this->reviewLength+1; $i++)
    {
        $this->arrayReview[$i][0] = 'review_' . $i;
        $this->arrayReview[$i][1] = $result[$i-1]['review'];
        $this->arrayReview[$i][2] = $result[$i-1]['username'];
        $this->arrayReview[$i][3] = 'aantal sterren: ' .  $result[$i-1]['score'];
    }
}


public function logout()
{
                
$_SESSION[] = array();

// destroy de sessie
session_destroy();
}
        
}           
?>