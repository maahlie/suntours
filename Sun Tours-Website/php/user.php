<?php

class User {

    public $SqlCommands;
    public $username;

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

            public function confMail($targetEmail,$mailBody,$mailSubject)
            {
                $mail = new Mail($mailBody, $mailSubject, $targetEmail);
                $mail->email();
            }

            public function codeEmailSend($email){
                $sql = "SELECT * FROM `users` WHERE `email` = ?";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $params = [$email];
                $stmt->execute($params);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result == false){
                    exit('dit email aderes is bij ons niet bekent.');
                }


                $sql = "UPDATE users SET activationCode = ? WHERE email = ?;"; //query, vraagtekens worden gevuld bij de execute met $params

                $stmt = $this->SqlCommands->pdo->prepare($sql);
                     
                if ($stmt) {
                     $pass = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
                    $params = [$pass, $email];
                    $stmt->execute($params);
                    $this->confMail($email, "De code voor uw wachtwoord herstel is: $pass.", "Code Voor Uw Wachtwoord Herstel");
                 }                   
            }

            public function changePassword($newPass, $email, $code){

                $result = $this->SqlCommands->selectFromWhere('activationCode', 'users', 'email', $email);
                $oldPass = $this->SqlCommands->selectFromWhere('passwrd', 'users', 'email', $email);

                $verify = password_verify($newPass, $oldPass[0]['passwrd']);

                if(count($result)!=0){
                    if($verify != true){
                        if($code == $result[0]['activationCode']){
                            $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);

                            $sql = "UPDATE users SET passwrd = ? WHERE email = ?;"; //query, vraagtekens worden gevuld bij de execute met $params
            
                            $stmt = $this->SqlCommands->pdo->prepare($sql);
                            
                            if ($stmt) {
                            $params = [$newPassHash, $email];
                            $stmt->execute($params);
                            $this->confMail($email, "Uw wachtwoord voor de Suntours website is veranderd.", "Suntours Wachtwoord Hersteld");
                            }
                        }else{
                            exit('De code was onjuist');
                        }   
                    }else{
                        exit('Het nieuwe wachtwoord is hetzelfde als uw huidige wachtwoord.');
                    }
                }else{
                    exit('Uw code of email was onjuist.');
                }
            }

            public function enterReg($email, $phoneNumber, $firstName, $surName, $username, $address, $postalCode, $passwd2, $passwd3){
    

                $hash = password_hash($passwd2, PASSWORD_DEFAULT);

                    $this->emailCheck($email);
                    $this->usernCheck($username);

                   $sql = "INSERT INTO users (username, email, passwrd, phoneNumber, firstName, surName, address, postalCode, active, activationCode) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
           
                   $stmt = $this->SqlCommands->pdo->prepare($sql);
                        
                   if ($stmt) {
                        $pass = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
                       $params = [$username, $email, $hash, $phoneNumber, $firstName, $surName, $address, $postalCode, false, $pass];
                       $stmt->execute($params);
                       $this->confMail($email, "De code voor uw activatie is: $pass.", "Activatie Code Voor uw Sun Tours Account");
                    }                   
            }
            public function enterContact($contactName, $email, $contactSubject, $contactBody){

                $sql = "INSERT INTO contact (name, email, subject, message) VALUES(?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
           
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                        
                if ($stmt) {
                    
                    $params = [$contactName, $email, $contactSubject, $contactBody];
                    $stmt->execute($params);
                    }                   
            }

            public function userLoginCheck($username, $passwrd){

                $this->SqlCommands->connectDB();
                //$verify = password_verify($hashed, $passwdLogin);
                $sql = "SELECT username, passwrd FROM users WHERE username = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$username];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result == false){
                    return 3;
                }
                $active = $this->getActivation($username, $result['passwrd']);
                $verify = password_verify($passwrd, $result['passwrd']);


                    if ($username == $result['username'] && $verify == true && $active['active']==1){
                        return 1;
                    }elseif($username == $result['username'] && $verify == true && $active['active'] != 1){
                        return 2;
                    }else{
                        return 3;
                    }
            }

            public function login($username){

                        // session_start();
                        $_SESSION['loggedIn']=true;
                        $_SESSION['username']=$username;
                        $this->username = $_SESSION['username'];
            }

            public function loginActivate($correct, $email){

                $this->SqlCommands->connectDB();

                $sql = "SELECT username FROM users WHERE email = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$email];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $username = $result['username'];
                if($correct == true){
                        // session_start();
                        $_SESSION['loggedIn']=true;
                        $_SESSION['username']=$username;
                        $this->username = $_SESSION['username'];
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
                $packages = ['Spanje', 'Turkije1', 'Turkije2', 'Egypte', 'Frankrijk'];
                $WrittenByUser = [0,0,0,0,0];
                $sql = 'SELECT packageID FROM `review` WHERE `username` = ?';
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $params = [$username];
                $stmt->execute($params);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             
                for($i = 0; $i < count($result); $i++){
                    for($j = 0; $j < 5; $j++){
                        if ($result[$i]['packageID'] == $packages[$j] || ($result[$i]['packageID'] . '1') == $packages[$j]){
                            $WrittenByUser[$j]++;
                        }
                    }
                }
                $sql = 'SELECT userID FROM `users` WHERE `username` = ?';
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $params = [$username];
                $stmt->execute($params);
                $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result2 = $result2[0]['userID'];

                $bookedByUser = [0,0,0,0,0];
                $sql = 'SELECT packageID FROM `booked` WHERE `userID` = ?';
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $params = [$result2];
                $stmt->execute($params);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for($i = 0; $i < count($result); $i++){
                    for($j = 0; $j < 5; $j++){
                        if ($result[$i]['packageID'] == $packages[$j]){
                            $bookedByUser[$j]++;
                        }
                    }
                }
                    
                if ($packageId != 'Turkije'){
                    $packageIndex = array_search($packageId, $packages);
                }else{
                    $packageIndex = array_search('Turkije1', $packages);
                }
                $a = 0;
                if ($bookedByUser[$packageIndex] <=  $WrittenByUser[$packageIndex]){
                    exit('boek een vakantie om deze review te schrijven');
                }


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

            public function getActivation($username, $passwrd){
                $this->SqlCommands->connectDB();

                $sql = "SELECT active FROM users WHERE username = ? AND passwrd = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                    $params = [$username, $passwrd];
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
            }

            public function activateUser($email, $actCode){
                $this->SqlCommands->connectDB();

                $result = $this->SqlCommands->selectFromWhere('activationCode', 'users', 'email', $email);

                if(count($result)!=0){
                    if($actCode == $result[0]['activationCode']){
                        $this->SqlCommands->connectDB();

                        $sql = "UPDATE users SET active = 1 WHERE email = ?;";
                        $stmt = $this->SqlCommands->pdo->prepare($sql);
                            $params = [$email];
                            $stmt->execute($params);
                            return 1;
                    }else{
                        return 2;
                    }
                }else{
                    return 3;
                }
            }
            public function getBookingValues($username){
                $this->SqlCommands->connectDB();
                $sql = 'SELECT userID FROM `users` WHERE `username` = ?';
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $params = [$username];
                $stmt->execute($params);
                $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $userID = $result2[0]['userID'];

                $sql = "SELECT * FROM booked WHERE userID = $userID";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->BookedVacations = $result;
                $this->BookedVacationCount = count($result);
            }
            // public function cancelResurvation()
            // {
            //     return 1;
            // } 
}           
?>

