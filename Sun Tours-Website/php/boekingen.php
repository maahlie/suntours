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
    private $totalPrice;
    private $id;
    private $commands;
    private $username;
    public $invoice;
    
    private $ticketPrice;
    private $carAmount;
    private $carPrice;
    private $busTicketAmount;
    private $busPrice;
    public function __construct($adults, $kids, $id, $travelTimeChoice, $totalPrice, $ticketPrice, $carAmount, $carPrice, $busTicketAmount, $busPrice)
    {
        $this->adults = $adults;
        $this->kids = $kids;
        $this->people = $this->kids + $this->adults;
        $this->package;
        $this->flights;
        $this->travelTimeChoice = $travelTimeChoice;
        $this->bus;
        $this->car;
        $this->id = $id;
        $this->totalPrice = $totalPrice;
        $this->ticketPrice = $ticketPrice;
        $this->carAmount = $carAmount;
        $this->carPrice = $carPrice;
        $this->busTicketAmount = $busTicketAmount;
        $this->busPrice = $busPrice;
        $this->userId = $this->getUserID();
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
        // $totalPrice = $this->totalCost();
                $userID = $this->userId[0]['userID'];
        $userIdInt = $userID + 0;
        $dateID = $this->travelTimeChoice;


        $this->commands = new SqlCommands();
        $this->commands->connectDB();

        $sql = "INSERT INTO booked (packageID, userID, dateID, aantalPersonen, packageCost, ticketPrice, carAmount, carPrice, busTicketAmount, busPrice) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
        
        $stmt = $this->commands->pdo->prepare($sql);
        if ($stmt) {
            $params = [$this->id, $userIdInt, $dateID, $this->people, $this->totalPrice, $this->ticketPrice, $this->carAmount, $this->carPrice, $this->busTicketAmount, $this->busPrice];
            
            $stmt->execute($params);
            exit("boeking succesvol");
         }
    }
    
}
?>