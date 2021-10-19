<?php
include "invoiceBackEnd.php";
class Booking {
    public $userId;
    private $adults;
    private $kids;
    private $travelTimeChoice;
    public $package;
    private $transport;
    private $flights;
    private $bus;
    private $car;
    private $packagePrice;
    private $id;
    private $commands;
    private $username;
    public $invoice;
    
    private $ticketPrice;
    private $carAmount;
    private $carPrice;
    private $busTicketAmount;
    private $busPrice;
    public function __construct($adults, $kids, $id, $travelTimeChoice, $packagePrice, $ticketPrice, $vliegM,  $carAmount, $carPrice, $rentalCarDays, $busTicketAmount, $busPrice, $busDays)
    {
        $this->adults = $adults;
        $this->kids = $kids;
        $this->people = $this->kids + $this->adults;
        $this->package;
        $this->vliegM = $vliegM;
        $this->travelTimeChoice = $travelTimeChoice;
        $this->bus;
        $this->car;
        $this->id = $id;
        $this->packagePrice = $packagePrice;
        $this->ticketPrice = $ticketPrice;
        $this->rentalCarDays = $rentalCarDays;
        $this->carAmount = $carAmount;
        $this->carPrice = $carPrice;
        $this->busTicketAmount = $busTicketAmount;
        $this->busPrice = $busPrice;
        $this->busDays = $busDays;
        $this->userId = $this->getUserID();
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

        $sql = "INSERT INTO booked (packageID, userID, dateID, aantalPersonen, packageCost, ticketPrice, carAmount, carPrice, carDays, busTicketAmount, busPrice, busDays) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
        
        $stmt = $this->commands->pdo->prepare($sql);
        if ($stmt) {
            $params = [$this->id, $userIdInt, $this->travelTimeChoice, $this->people, $this->packagePrice, $this->ticketPrice, $this->carAmount, $this->carPrice, $this->rentalCarDays, $this->busTicketAmount, $this->busPrice, $this->busDays];
            $stmt->execute($params);
            $invoice = new Invoice($userID, $this->id, $userIdInt, $this->packagePrice, $this->people, $this->ticketPrice, $this->carAmount, $this->carPrice, $this->busTicketAmount, $this->busPrice, $this->rentalCarDays, $this->busDays);
            $invoice->genInvoice();

            //vliegmaatschappij mail
            if($this->ticketPrice != 0){

                switch($this->vliegM){
                    case "KLM":
                        $targetEmail = "KLMService@yopmail.com";
                        $body = "Hallo,<br>
                        We willen graag " . $this->people . " vluchten boeken voor";
                        break;
                    case "Ryan air":
                        $targetEmail = "ryanAirService@yopmail.com";
                        $body = "";
                        break;
                    case "Iberia":
                        $targetEmail = "iberiaService@yopmail.com";
                        $body = "";
                        break;

                $subject = "Vluchten Boeken";
                $mailer = new Mail($body, $subject, $targetEmail);

                }

            }

            exit("boeking succesvol");
        }
    }
    
}
?>