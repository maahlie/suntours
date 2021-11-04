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
        //haalt de gebruikersnaam en wachtwoord uit de users tabel van de ingelogde gebruiker op 
        $this->SqlCommands->connectDB();
        $sql = "SELECT username, passwrd FROM users WHERE username = ?;";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username];
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //als er niks opgehaalt kan worden dan exit met een return 3 (wachtwoord of gebruikersnaam is onjuist)
        if ($result == false) {
            return 3;
        }
        //haalt de activatie status op 
        $active = $this->getActivation($username, $result['passwrd']);
    
        //controleert het wachtwoord en slaat het resultaat op in verify
        $verify = password_verify($passwrd, $result['passwrd']);

        // als het wachtwoord en gebruikersnaam klopt en het een actief account is, dan is het inloggen gelukt.
        if ($username == $result['username'] && $verify == true && $active['active'] == 1) {
            return 1;
        // als het wachtwoord en gebruikersnaam klopt maar het account is niet actief, dan krijg je daar een melding van
        } elseif ($username == $result['username'] && $verify == true && $active['active'] != 1) {
            return 2;
        //als de gebruikersnaam of wachtwoord verkeerd is en het account is wel geactiveert dan krijg je de bijbehorende melding
        }elseif($username == $result['username'] && $verify != true && $active['active'] == 1){
            return 3;
        }
        //als de gebruikersnaam en wachtwoord kloppen en het account was inet verwijderd dan wordt je ingelogd.
        if ($username == $result['username'] && $verify == true && $active['deleted'] == 0) {
            return 1;
        } else {
            return 4;
        }

    }

    //logd de gebruiker in.
    public function login($username)
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;
        $this->username = $_SESSION['username'];
    }

    public function loginActivate($correct, $email)
    {
        $this->SqlCommands->connectDB();
        //haalt de gebruikersnaam van de gebruiker met de gespecifiseerde email op.
        $sql = "SELECT username FROM users WHERE email = ?;";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$email];
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $username = $result['username'];

        //als correct is meegegeven wordt de gebruiker ingelogd
        if ($correct == true) {
            $this->login($username);
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

        //haalt de packageID van de ingelogde gebruiker uit de review tabel
        $this->SqlCommands->connectDB();
        $packages = ['Spanje', 'Turkije1', 'Turkije2', 'Egypte', 'Frankrijk'];
        $WrittenByUser = [0, 0, 0, 0, 0];
        $sql = 'SELECT packageID FROM `review` WHERE `username` = ?';
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //telt hoeveel reviews de gebruiker geschreven heeft voor elke vakantie appart.
        for ($i = 0; $i < count($result); $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($result[$i]['packageID'] == $packages[$j] || ($result[$i]['packageID'] . '1') == $packages[$j]) {
                    $WrittenByUser[$j]++;
                }
            }
        }

        //haalt het userID  van de gebruiker op uit de tabel users
        $sql = 'SELECT userID FROM `users` WHERE `username` = ?';
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username];
        $stmt->execute($params);
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result2 = $result2[0]['userID'];

        $bookedByUser = [0, 0, 0, 0, 0];

        //haalt de packageID op uit de tabel booked
        $sql = 'SELECT packageID FROM `booked` WHERE `userID` = ?';
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$result2];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //telt hoeveel boekingen een user gemaakt heeft van elke vakantie appart.
        for ($i = 0; $i < count($result); $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($result[$i]['packageID'] == $packages[$j]) {
                    $bookedByUser[$j]++;
                }
            }
        }
        //zoekt naar de juiste index van het land
        if ($packageId != 'Turkije') {
            $packageIndex = array_search($packageId, $packages);
        } else {
            $packageIndex = array_search('Turkije1', $packages);
        }

        //als er van de reis niet genoeg boekingen gedaan zijn om een review te schrijven krijg je het volgende bericht.
        if ($bookedByUser[$packageIndex] <=  $WrittenByUser[$packageIndex]) {
            exit('boek een vakantie om deze review te schrijven');
        }

        // voegt een nieuwe review toe aan de review tabel
        $sql = "INSERT INTO review (packageId, score, reviewSubject, review, reccomendation, username) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        if ($stmt) {
            $params = [$packageId, $score, $reviewSubject, $review, $reccomendation, $username];
            $stmt->execute($params);
        }
        //roept de functie aan om de review te laten zien.
        $this->showReview();
        exit("Uw review is ingezonden, bedankt voor uw moeite.");
    }

    //showReview laat de laatste 12 reviews zien op de pagina van de website
    public function showReview()
    {
        $this->SqlCommands->connectDB();

        //haalt de laatste 12 reviews op uit de database en slaat de juiste waardens op in arrayReview
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

        //haalt active en deleted op uit de users tabel
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

        //haalt het user id op uit de users tabel
        $sql = 'SELECT userID FROM `users` WHERE `username` = ?';
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $params = [$username];
        $stmt->execute($params);
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userID = $result2[0]['userID'];

        //haalt alles op uit booked van de ingelogde user
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
            $this->cancelMail($resurvationNumber);
            $this->SqlCommands->connectDB();
            $sql = "DELETE FROM `booked` WHERE `booked`.`bookingID` = $bookingID";
            $stmt = $this->SqlCommands->pdo->prepare($sql);
            $stmt->execute();
            exit("Uw reis is geannuleerd.");
        }
    }
    public function selectFromWhere($column, $table, $where, $param) {
        $sql = "SELECT " . $column .  " FROM " . $table . " WHERE " . $where . "= ?";
        $stmt = $this->pdo->prepare($sql);
        $params = [$param];

        $stmt->execute($params);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);   
        }

        return $result;
    }

    public function cancelMail($indexNumber)
    {
        $userData = $this->BookedVacations[$indexNumber];
        $userName = $_SESSION['username'];
        $numberOfPeople = $userData["aantalPersonen"];
        $packageId = $userData["packageID"];
        $busPrice = $userData["busPrice"];
        $busTicketAmount = $userData["busTicketAmount"];
        $busDays = $userData["busDays"];
        $carBrand = $userData["carBrand"];
        $carDays = $userData["carDays"];
        $dateID = $userData["dateID"];
        $vliegmaatschapij = "KLM";
        $busStartDate = $userData['startingDate'];
        $carAmount = $userData['carAmount'];
        // $"startDate, endDate, startTime, endTime"-- traveldates
        // $firstName, surName", "users", "userID"-- user 
        //"email",-- "mailinglist");

        //dateTimeFlight
        //nameOfUser
        //emails
        $this->SqlCommands = new SqlCommands();

        $this->SqlCommands->connectDB();
        $sql = "SELECT userID FROM users WHERE userName = ?";
        $stmt = $this->SqlCommands->pdo->prepare($sql);
        $param = [$userName];
        $stmt->execute($param);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userId = $result[0]['userID'];
        // $userIdInt = $userID + 0;


        //$this->SqlCommands->connectDB();
        $this->commands = new SqlCommands();
        $this->commands->connectDB();
        $dateTimeFlight = $this->commands->selectFromWhere("startDate, endDate, startTime, endTime", "traveldates", "dateID", $dateID);
        $nameOfUser = $this->commands->selectFromWhere("firstName, surName", "users", "userID", $userId);
        $emails = $this->commands->selectFromAssoc("email", "mailinglist");
        $a = 0;

        $airlines = ["KLM", "Ryan air", "Iberia"];
        $destinations = ["Egypte", "Frankrijk", "Spanje", "Turkije1", "Turkije2", ];
        
        
        if($userData['ticketPrice'] != "0.00")
            {
                for ($i = 0; $i < 3; $i++)
                {
                    if ($vliegmaatschapij == $airlines[$i])
                    {
                        $targetEmail = $emails[$i]['email'];
                        $body = "Hallo,<br>
                        Wij hebben bij u geboek voor " . $numberOfPeople . " vluchten " . $dateTimeFlight[0]['startDate'] . " om " . substr($dateTimeFlight[0]['startTime'], 0, -10) . ". De retour is op ". $dateTimeFlight[0]['endDate'] . " om " . substr($dateTimeFlight[0]['endTime'], 0, -10) . ".<br>" .
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'] . " Helaas moeten we deze boeking afzeggen.";
                        $subject = "Vluchten annuleren Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                }
            }

            for ($i = 0; $i < 5; $i++)
            {
                if ($packageId == $destinations[$i])
                {
                    $targetEmail = $emails[$i+3]['email'];
                    $body = "Hello,<br>
                    We have recently orderd rooms for " . $numberOfPeople . " people, from " . $dateTimeFlight[0]['startDate'] . " to ". $dateTimeFlight[0]['endDate'] . ".<br>" . 
                    "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'] . ", We are sorry to say we will be cancelling this resurvation.";
                    $subject = "Canceling Stay Sun Tours";
                    $mailer = new Mail($body, $subject, $targetEmail);
                    $mailer->email();
                }
                if($busPrice != 0)
                {
                    if (($packageId== "Turkije1" || $packageId == "Turkije2") && $i+8 == 11)
                    {
                        $targetEmail = $emails[$i+8]['email'];
                        $body = "Hello,<br>
                        We would like to inform you that our booking of " . $busTicketAmount . " tickets for " . $busDays . " days, " . "that are active from: " . $busStartDate . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'] . " Will have to be canceled.";
                        $subject = "Public transport canceling Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                    if ($packageId == $destinations[$i] && $i+8 < 11)
                    {
                        $targetEmail = $emails[$i+8]['email'];
                        $body = "Hello,<br>
                        We would like to inform you that our booking of " . $busTicketAmount . " tickets for " . $busDays . " days, " . "that are active from: " . $busStartDate . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'] . " Will have to be canceled.";
                        $subject = "Public transport canceling Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                }

                if($carBrand != "0")
                {
                    if (($packageId == "Turkije1" || $packageId == "Turkije2") && $i+12 == 15)
                    {
                        $targetEmail = $emails[$i+12]['email'];
                        $body = "Hello,<br>
                        We would like to inform you that our order of " . $carAmount . " cars for " . $carDays . " days, " . "of the brand: " . $carBrand . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'] . "will have to be canceled.";
                        $subject = "Public transport canceling Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                    if($packageId == $destinations[$i] && $i+12 < 15)
                    {
                        $targetEmail = $emails[$i+12]['email'];
                        $body = "Hello,<br>
                        We would like to inform you that our order of " . $carAmount . " cars for " . $carDays . " days, " . "of the brand: " . $carBrand . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'] . "will have to be canceled.";
                        $subject = "Public transport canceling Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                }
            }
    }
}
