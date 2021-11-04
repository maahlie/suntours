<?php
include "invoiceBackEnd.php";
class Booking {
    public $userId;
    private $adults;
    private $kids;
    private $travelTimeChoice;
    public $package;
    private $bus;
    private $car;
    private $packagePrice;
    private $id;
    private $carBrand;
    private $commands;
    private $busStartDate;
    public $invoice;
    private $ticketPrice;
    private $carAmount;
    private $carPrice;
    private $busTicketAmount;
    private $busPrice;
    private $startingDate;
    private $returnDate;

    public function __construct($adults, $kids, $id, $travelTimeChoice, $packagePrice, $ticketPrice, $vliegM, $vliegveld, $carAmount, $carPrice, $rentalCarDays, $carBrand, $busTicketAmount, $busPrice, $busDays,$busStartDate, $startingDate, $returnDate)    
    {
        $this->adults = $adults;
        $this->kids = $kids;
        $this->people = $this->kids + $this->adults;
        $this->package;
        $this->vliegM = $vliegM;
        $this->vliegveld = $vliegveld;
        $this->travelTimeChoice = $travelTimeChoice;
        $this->bus;
        $this->id = $id;
        $this->packagePrice = $packagePrice;
        $this->ticketPrice = $ticketPrice;
        $this->rentalCarDays = $rentalCarDays;
        $this->carAmount = $carAmount;
        $this->carPrice = $carPrice;
        $this->carBrand = $carBrand;
        $this->busTicketAmount = $busTicketAmount;
        $this->busPrice = $busPrice;
        $this->busDays = $busDays;
        $this->busStartDate = $busStartDate;
        $this->userId = $this->getUserID();
        $this->carBrand = $carBrand;
        $this->startingDate = $startingDate;
        $this->returnDate = $returnDate;
    }

    //haalt de user id op aan de hand van de ingelogde username.
    private function getUserID(){
        $this->commands = new SqlCommands();
        $this->commands->connectDB();
        $username = $_SESSION['username'];
        $userID = $this->commands->selectFromWhere("userID", "users", "username", $username);
        return $userID;
    }

    public function confirmOrder(){
        $userID = $this->userId[0]['userID'];
        $userIdInt = $userID + 0;

        $this->commands = new SqlCommands();
        $this->commands->connectDB();

        $sql = "INSERT INTO booked (packageID, userID, dateID, aantalPersonen, packageCost, ticketPrice, carAmount, carPrice, carDays, busTicketAmount, busPrice, busDays, carBrand, startingDate, returnDate) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
        
        $stmt = $this->commands->pdo->prepare($sql);
        if ($stmt) {
            $params = [$this->id, $userIdInt, $this->travelTimeChoice, $this->people, $this->packagePrice, $this->ticketPrice, $this->carAmount, $this->carPrice, $this->rentalCarDays, $this->busTicketAmount, $this->busPrice, $this->busDays, $this->carBrand, $this->startingDate, $this->returnDate];
            $stmt->execute($params);

            $invoice = new Invoice($userID, $this->id, $userIdInt, $this->packagePrice, $this->people, $this->ticketPrice, $this->carAmount, $this->carPrice, $this->busTicketAmount, $this->busPrice, $this->rentalCarDays, $this->busDays);
            $invoice->genInvoice();

            $this->commands = new SqlCommands();
            $this->commands->connectDB();

            $dateTimeFlight = $this->commands->selectFromWhere("startDate, endDate, startTime, endTime", "traveldates", "dateID", $this->travelTimeChoice);
            $nameOfUser = $this->commands->selectFromWhere("firstName, surName", "users", "userID", $userIdInt);
            $emails = $this->commands->selectFromAssoc("email", "mailinglist");
            
            //vliegmaatschappij mail
            $airlines = ["KLM", "Ryan air", "Iberia"];
            $destinations = ["Egypte", "Frankrijk", "Spanje", "Turkije1", "Turkije2", ];

            

            if($this->vliegM != "")
            {
                for ($i = 0; $i < 3; $i++)
                {
                    if ($this->vliegM == $airlines[$i])
                    {
                        $targetEmail = $emails[$i]['email'];
                        $body = "Hallo,<br>
                        We willen graag " . $this->people . " vluchten boeken voor " . $dateTimeFlight[0]['startDate'] . " om " . substr($dateTimeFlight[0]['startTime'], 0, -10) . ". De retour is op ". $dateTimeFlight[0]['endDate'] . " om " . substr($dateTimeFlight[0]['endTime'], 0, -10) . " vanaf " . $this->vliegveld . ".<br>" .
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Vluchten Boeken Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                }
            }

            for ($i = 0; $i < 5; $i++)
            {
                if ($this->id == $destinations[$i])
                {
                    $targetEmail = $emails[$i+3]['email'];
                    $body = "Hello,<br>
                    We would like to book rooms for " . $this->people . " people, from " . $dateTimeFlight[0]['startDate'] . " to ". $dateTimeFlight[0]['endDate'] . ".<br>" . 
                    "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                    $subject = "Booking Stay Sun Tours";
                    $mailer = new Mail($body, $subject, $targetEmail);
                    $mailer->email();
                }
                if($this->busPrice != 0)
                {
                    if (($this->id == "Turkije1" || $this->id == "Turkije2") && $i+8 == 11)
                    {
                        $targetEmail = $emails[$i+8]['email'];
                        $body = "Hello,<br>
                        We would like to book " . $this->busTicketAmount . " tickets for " . $this->busDays . " days, " . "that are active from: " . $this->busStartDate . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Public transport booking Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                    if ($this->id == $destinations[$i] && $i+8 < 11)
                    {
                        $targetEmail = $emails[$i+8]['email'];
                        $body = "Hello,<br>
                        We would like to book " . $this->busTicketAmount . " tickets for " . $this->busDays . " days, " . "that are active from: " . $this->busStartDate . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Public transport booking Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                }

                if($this->carBrand != "0")
                {
                    if (($this->id == "Turkije1" || $this->id == "Turkije2") && $i+12 == 15)
                    {
                        $targetEmail = $emails[$i+12]['email'];
                        $body = "Hello,<br>
                        We would like to book " . $this->carAmount . " cars for " . $this->rentalCarDays . " days, " . "of the brand: " . $this->carBrand . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Public transport booking Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                    if($this->id == $destinations[$i] && $i+12 < 15)
                    {
                        $targetEmail = $emails[$i+12]['email'];
                        $body = "Hello,<br>
                        We would like to book " . $this->carAmount . " cars for " . $this->rentalCarDays . " days, " . "of the brand: " . $this->carBrand . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Public transport booking Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                    }
                }
            }
            
            exit("boeking succesvol");
        }
    }

    public function maxPersonenVlucht() {
        $this->commands = new SqlCommands();
        $this->commands->connectDB();

        $sql = "SELECT aantalPersonen FROM booked";
        $stmt = $this->commands->pdo->prepare($sql);

        $stmt->execute();
        $result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT aantalPersonen FROM booked WHERE dateID = 1";
        $stmt = $this->commands->pdo->prepare($sql);

        $stmt->execute();
        $dateID1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT aantalPersonen FROM booked WHERE dateID = 2";
        $stmt = $this->commands->pdo->prepare($sql);

        $stmt->execute();
        $dateID2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT aantalPersonen FROM booked WHERE dateID = 3";
        $stmt = $this->commands->pdo->prepare($sql);

        $stmt->execute();
        $dateID3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $maxPersonen = 0;

        $dateId = $_POST['reistijden'];
        $country = $_POST['packageID'];
        
        if ($country == 'Spanje')           {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Turkije1')  {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Turkije2')  {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Egypte')    {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Frankrijk') {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['aantalPersonen'];
                    if($maxPersonen >= 200) {
                        exit("Er zijn al te veel boekingen");
                    } 
                }
                return $this->confirmOrder();
            }
        }
    }
}
