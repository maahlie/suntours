<?php

class User
{

    public $SqlCommands;
    public $username;

    public function __construct()
    {
        $this->SqlCommands = new SqlCommands();
    }

    //haalt de emails op
    private function emailCheck($email)
    {
        //maakt connectie met de database
        $this->SqlCommands->connectDB();

        $result = $this->SqlCommands->selectFrom("email", "users");

        //checkt de emails tegen de ingevoerde email en controleerd of het account verwijderd is of niet.
        for ($i = 0; $i < count($result); $i++) {
            if ($email == $result[$i][0]) {
                $this->SqlCommands->connectDB();

                $sql = "SELECT deleted FROM users WHERE email = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $params = [$email];
                $stmt->execute($params);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result["deleted"] == 1) {
                    return 1;
                }
                return 0;
            }
        }
        return 2;
    }

    //haalt de username op
    private function usernCheck($username)
    {
        $this->SqlCommands->connectDB();
        $result = $this->SqlCommands->selectFrom("username", "users");

        //checkt de usernames tegen de ingevoerde username
        for ($i = 0; $i < count($result); $i++) {
            if ($username == $result[$i][0]) {
                $text = "username bestaat al!";
                exit($text);
            }
        }
    }

    //roep de email functie aan om een mail te versturen.
    public function confMail($targetEmail, $mailBody, $mailSubject)
    {
        $mail = new Mail($mailBody, $mailSubject, $targetEmail);
        $mail->email();
    }

    //deze functie verstuurd een mail met een code(activatie).
    public function codeEmailSend($email)
    {
        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$email];
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            exit('uw actie is helaas niet gelukt, probeer opnieuw.');
        }

        $sql = "UPDATE users SET activationCode = ? WHERE email = ?;"; //query, vraagtekens worden gevuld bij de execute met $params

        $stmt = $this->SqlCommands->pdo->prepare($sql);

        if ($stmt) {
            $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);         //maakt de code
            $params = [$pass, $email];
            $stmt->execute($params);
            $this->confMail($email, "De code die u in het gevraagde veld in moet vullen is: $pass.", "Uw aangevraagde code");
        }
    }

    //veranderen van wachtwoord
    public function changePassword($newPass, $email, $code)
    {

        $result = $this->SqlCommands->selectFromWhere('activationCode', 'users', 'email', $email);
        $oldPass = $this->SqlCommands->selectFromWhere('passwrd', 'users', 'email', $email);

        $verify = password_verify($newPass, $oldPass[0]['passwrd']);

        if (count($result) != 0) {
            if ($verify != true) {
                if ($code == $result[0]['activationCode']) {
                    $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);

                    $sql = "UPDATE users SET passwrd = ? WHERE email = ?;"; //query, vraagtekens worden gevuld bij de execute met $params

                    $stmt = $this->SqlCommands->pdo->prepare($sql);

                    if ($stmt) {
                        $params = [$newPassHash, $email];
                        $stmt->execute($params);
                        $this->confMail($email, "Uw wachtwoord voor de Suntours website is veranderd.", "Suntours Wachtwoord Hersteld");
                    }
                } else {
                    exit('De code was onjuist');
                }
            } else {
                exit('Het nieuwe wachtwoord is hetzelfde als uw huidige wachtwoord.');
            }
        } else {
            exit('Uw code of email was onjuist.');
        }
    }

    //voert de registratie door in de database.
    public function enterReg($email, $phoneNumber, $firstName, $surName, $username, $address, $postalCode, $passwd2, $passwd3, $city)
    {
        //hashed je wachtwoord
        $hash = password_hash($passwd2, PASSWORD_DEFAULT);

        //controleerd of je email al in de db staat.
        $emailCheck = $this->emailCheck($email);
        if ($emailCheck == 0) {
            $text = "email bestaat al!";
            exit($text);
        //kijkt of de het account bestaat maar gedactiveerd is.
        } elseif ($emailCheck == 1) {
            exit("Account gedeactiveerd, ga naar de activatie pagina om te heractiveren.");
        }
        //kijkt of de username al in de db staat.
        $this->usernCheck($username);

        //this querry insert the data into the db
        $sql = "INSERT INTO users (username, email, passwrd, phoneNumber, firstName, surName, address, postalCode, active, activationCode, City) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params

        $stmt = $this->SqlCommands->pdo->prepare($sql);

        if ($stmt) {
            $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $params = [$username, $email, $hash, $phoneNumber, $firstName, $surName, $address, $postalCode, false, $pass, $city];
            $stmt->execute($params);
            $this->confMail($email, "De code voor uw activatie is: $pass.", "Activatie Code Voor uw Sun Tours Account");
        }
    }

    //voert het contact form door in db.
    public function enterContact($contactName, $email, $contactSubject, $contactBody)
    {

        $sql = "INSERT INTO contact (name, email, subject, message) VALUES(?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params

        $stmt = $this->SqlCommands->pdo->prepare($sql);

        if ($stmt) {
            $params = [$contactName, $email, $contactSubject, $contactBody];
            $stmt->execute($params);
        }
    }

    //checks if the login should be succesfull or not.
    public function userLoginCheck($username, $passwrd)
    {

        $this->SqlCommands->connectDB();
        //$verify = password_verify($hashed, $passwdLogin);
        $sql = "SELECT username, passwrd FROM users WHERE username = ?;";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username];
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return 3;
        }
        $active = $this->getActivation($username, $result['passwrd']);
        $verify = password_verify($passwrd, $result['passwrd']);

        if ($username == $result['username'] && $verify == true && $active['deleted'] == 0) {
            return 1;
        } else {
            return 4;
        }

        if ($username == $result['username'] && $verify == true && $active['active'] == 1) {
            return 1;
        } elseif ($username == $result['username'] && $verify == true && $active['active'] != 1) {
            return 2;
        } else {
            return 3;
        }
    }

    //actually logs the person in.
    public function login($username)
    {
        // session_start();
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;
        $this->username = $_SESSION['username'];
    }

    public function loginActivate($correct, $email)
    {
        $this->SqlCommands->connectDB();

        $sql = "SELECT username FROM users WHERE email = ?;";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$email];
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $username = $result['username'];
        if ($correct == true) {
            // session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $username;
            $this->username = $_SESSION['username'];
        }
    }

    //stuurd een mail naar ons met alle data en tekst uit het contact form.
    public function contact($email, $mailBody, $mailSubject, $contactName)
    {
        $targetEmail = 'SunTours.devOps@hotmail.com';
        $completeBody = "Deze email is verzonden door email addres: " . $email . "<br/>" . "Naam: " . $contactName . "<br/>" . $mailBody;
        $this->confMail($targetEmail, $completeBody, $mailSubject);
        exit('Uw Bericht is succelvol verzonden en wordt zo snel mogenlijk in behandeling genomen.');
    }

    //enterReview maakt een niewe review aan in de database aan de hand van ingevoerde waardens
    public function enterReview($packageId, $score, $reviewSubject, $review, $reccomendation, $username)
    {
        //controleerd of de gebruiker is ingelogd.
        if (!isset($_SESSION['username'])) {
            exit('log in on een review achter te laten');
        }

        $this->SqlCommands->connectDB();
        $packages = ['Spanje', 'Turkije1', 'Turkije2', 'Egypte', 'Frankrijk'];
        $WrittenByUser = [0, 0, 0, 0, 0];
        $sql = 'SELECT packageID FROM `review` WHERE `username` = ?';
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($result); $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($result[$i]['packageID'] == $packages[$j] || ($result[$i]['packageID'] . '1') == $packages[$j]) {
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

        $bookedByUser = [0, 0, 0, 0, 0];
        $sql = 'SELECT packageID FROM `booked` WHERE `userID` = ?';
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$result2];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($result); $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($result[$i]['packageID'] == $packages[$j]) {
                    $bookedByUser[$j]++;
                }
            }
        }

        if ($packageId != 'Turkije') {
            $packageIndex = array_search($packageId, $packages);
        } else {
            $packageIndex = array_search('Turkije1', $packages);
        }
        $a = 0;
        if ($bookedByUser[$packageIndex] <=  $WrittenByUser[$packageIndex]) {
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
        for ($i = 1; $i < $this->reviewLength + 1; $i++) {
            $this->arrayReview[$i][0] = 'review_' . $i;
            $this->arrayReview[$i][1] = $result[$i - 1]['review'];
            $this->arrayReview[$i][2] = $result[$i - 1]['username'];
            $this->arrayReview[$i][3] = 'aantal sterren: ' .  $result[$i - 1]['score'];
        }
    }

    //simpele log uit functie
    public function logout()
    {
        $_SESSION[] = array();
        // destroy de sessie
        session_destroy();
    }

    //kijk of het account geactiveerd is.
    public function getActivation($username, $passwrd)
    {
        $this->SqlCommands->connectDB();

        $sql = "SELECT active, deleted FROM users WHERE username = ? AND passwrd = ?;";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username, $passwrd];
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //activeert de user
    public function activateUser($email, $actCode)
    {
        $this->SqlCommands->connectDB();

        //haalt de activatie code op
        $result = $this->SqlCommands->selectFromWhere('activationCode', 'users', 'email', $email);

        if (count($result) != 0) {
            //check of de ingevulde code overeen komt met de verwachte code.
            if ($actCode == $result[0]['activationCode']) {
                $this->SqlCommands->connectDB();
                //zet account op actief
                $sql = "UPDATE users SET active = 1, deleted = 0 WHERE email = ?;";
                $stmt = $this->SqlCommands->pdo->prepare($sql);
                $params = [$email];
                $stmt->execute($params);
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public function getBookingValues($username)
    {
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

    //zet account status op deleted.
    public function accDelete()
    {
        $this->SqlCommands->connectDB();
        $username = $_SESSION['username'];
        //zet account status op deleted en active op false.
        $sql = "UPDATE users SET deleted = 1, active = 0 WHERE username = ?;";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username];
        $stmt->execute($params);
        $this->logout();
        exit("Account succesvol verwijderd");
    }
    
    //wordt aangeroepen waneer er op een annuleer knop gedrukt is
    public function cancelResurvation($resurvationNumber)
    {
        //haalt de de ingelogde gebruiker op en maakt de datum/tijd variabelen aan.
        $this->getBookingValues($_SESSION['username']);
        date_default_timezone_set(@date_default_timezone_get());
        $todaysDate = strtotime(date("Ymd"));
        $vacationStartingDate = strtotime('' . $this->BookedVacations[$resurvationNumber]['startingDate']);
        $secondsInOneWeek = 3600 * 24 * 7;

        //kijkt of de reis geannuleerd mag worden.
        if ($vacationStartingDate - $todaysDate - $secondsInOneWeek < 0) {
            exit("Neem contact met ons op om een reis die over minder dan een week begint te annuleren.");
        } else if ($vacationStartingDate - $todaysDate <= 0) {
            exit("Een gestarte of afgelopen vakantie kan niet geannuleerd worden.");
        } else {
            //het id van de geannuleerde reis wordt opgehaalt
            $bookingID = $this->BookedVacations[$resurvationNumber]['bookingID'];

            //de geannuleerde reis wordt verwijderd uit de database
            $this->SqlCommands->connectDB();
            $sql = "DELETE FROM `booked` WHERE `booked`.`bookingID` = $bookingID";
            $stmt = $this->SqlCommands->pdo->prepare($sql);
            $stmt->execute();

            exit("Uw reis is geannuleerd.");
        }
    }
}
