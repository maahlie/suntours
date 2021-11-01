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
        // $this->finalPrices = $this->calcFinalPrice();
        // $this->username = $_SESSION['username'];
    }

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
            if($this->vliegM != ""){
                switch($this->vliegM){
                    case "KLM":
                        $targetEmail = $emails[0]['email'];
                        $body = "Hallo,<br>
                        We willen graag " . $this->people . " vluchten boeken voor " . $dateTimeFlight[0]['startDate'] . " om " . substr($dateTimeFlight[0]['startTime'], 0, -10) . ". De retour is op ". $dateTimeFlight[0]['endDate'] . " om " . substr($dateTimeFlight[0]['endTime'], 0, -10) . " vanaf " . $this->vliegveld . ".<br>" .
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Vluchten Boeken Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                    case "Ryan air":
                        $targetEmail = $emails[1]['email'];
                        $body = "Hallo,<br>
                        We willen graag " . $this->people . " vluchten boeken voor " . $dateTimeFlight[0]['startDate'] . " om " . substr($dateTimeFlight[0]['startTime'], 0, -10) . ". De retour is op ". $dateTimeFlight[0]['endDate'] . " om " . substr($dateTimeFlight[0]['endTime'], 0, -10) . " vanaf " . $this->vliegveld . ".<br>" . 
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Vluchten Boeken Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                    case "Iberia":
                        $targetEmail = $emails[2]['email'];
                        $body = "Hallo,<br>
                        We willen graag " . $this->people . " vluchten boeken voor " . $dateTimeFlight[0]['startDate'] . " om " . substr($dateTimeFlight[0]['startTime'], 0, -10) . ". De retour is op ". $dateTimeFlight[0]['endDate'] . " om " . substr($dateTimeFlight[0]['endTime'], 0, -10) . " vanaf " . $this->vliegveld . ".<br>" . 
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Vluchten Boeken Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                }
            }

                switch($this->id){
                    case "Egypte":
                        $targetEmail = $emails[3]['email'];
                        $body = "Hello,<br>
                        We would like to book rooms for " . $this->people . " people, from " . $dateTimeFlight[0]['startDate'] . " to ". $dateTimeFlight[0]['endDate'] . ".<br>" . 
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Booking Stay Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                    case "Frankrijk":
                        $targetEmail = $emails[4]['email'];
                        $body = "Hello,<br>
                        We would like to book rooms for " . $this->people . " people, from " . $dateTimeFlight[0]['startDate'] . " to ". $dateTimeFlight[0]['endDate'] . ".<br>" .
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Booking Stay Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                    case "Spanje":
                        $targetEmail = $emails[5]['email'];
                        $body = "Hello,<br>
                        We would like to book rooms for " . $this->people . " people, from " . $dateTimeFlight[0]['startDate'] . " to ". $dateTimeFlight[0]['endDate'] . ".<br>" .
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Booking Stay Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                    case "Turkije1":
                        $targetEmail = $emails[6]['email'];
                        $body = "Hello,<br>
                        We would like to book rooms for " . $this->people . " people, from " . $dateTimeFlight[0]['startDate'] . " to ". $dateTimeFlight[0]['endDate'] . ".<br>" . 
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Booking Stay Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                    case "Turkije2":
                        $targetEmail = $emails[7]['email'];
                        $body = "Hello,<br>
                        We would like to book rooms for " . $this->people . " people, from " . $dateTimeFlight[0]['startDate'] . " to ". $dateTimeFlight[0]['endDate'] . ".<br>".
                        "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                        $subject = "Booking Stay Sun Tours";
                        $mailer = new Mail($body, $subject, $targetEmail);
                        $mailer->email();
                        break;
                }

                if($this->busPrice != 0){
                    switch($this->id){
                        case "Egypte":
                            $targetEmail = $emails[8]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->busTicketAmount . " tickets for " . $this->busDays . " days, " . "that are active from: " . $this->busStartDate . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                        case "Frankrijk":
                            $targetEmail = $emails[9]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->busTicketAmount . " tickets for " . $this->busDays . " days, " . "that are active from: " . $this->busStartDate . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                        case "Spanje":
                            $targetEmail = $emails[10]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->busTicketAmount . " tickets for " . $this->busDays . " days, " . "that are active from: " . $this->busStartDate . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                        case "Turkije1":
                        case "Turkije2":
                            $targetEmail = $emails[11]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->busTicketAmount . " tickets for " . $this->busDays . " days, " . "that are active from: " . $this->busStartDate . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                    }
                }

                if($this->carBrand != ""){
                    switch($this->id){
                        case "Egypte":
                            $targetEmail = $emails[12]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->carAmount . " cars for " . $this->rentalCarDays . " days, " . "of the brand: " . $this->carBrand . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                        case "Frankrijk":
                            $targetEmail = $emails[13]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->carAmount . " cars for " . $this->rentalCarDays . " days, " . "of the brand: " . $this->carBrand . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                        case "Spanje":
                            $targetEmail = $emails[14]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->carAmount . " cars for " . $this->rentalCarDays . " days, " . "of the brand: " . $this->carBrand . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                        case "Turkije1":
                        case "Turkije2":
                            $targetEmail = $emails[15]['email'];
                            $body = "Hello,<br>
                            We would like to book " . $this->carAmount . " cars for " . $this->rentalCarDays . " days, " . "of the brand: " . $this->carBrand . ".<br>".
                            "In name of: " . $nameOfUser[0]['firstName'] . " " . $nameOfUser[0]['surName'];
                            $subject = "Public transport booking Sun Tours";
                            $mailer = new Mail($body, $subject, $targetEmail);
                            $mailer->email();
                            break;
                    }
                }


            exit("boeking succesvol");
        }
    }
    
}
?>