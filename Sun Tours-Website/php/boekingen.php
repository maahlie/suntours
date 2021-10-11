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
    private $packageCost;
    private $id;
    private $commands;
    private $username;
    public $invoice;

    public function __construct($adults, $kids, $id, $travelTimeChoice)
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

    private function calcPackageCost(){
        $this->commands = new SqlCommands();
        $this->commands->connectDB();
        $this->package = $this->commands->selectFromWhere("price", "packages", "packageID", $this->id);
        $packageCost = $this->package[0]["price"] * $this->people;
        return $packageCost;
    }

    private function totalCost(){
        $totalCost = $this->calcPackageCost($this->id);
        return $totalCost;
    }
// + $this->flights + $this->bus + $this->car
//$flights, $bus, $car,
    public function showCost(){
        echo $this->totalCost();
    }

    public function confirmOrder(){
        $totalPrice = $this->totalCost();
        $packageID = $this->id;
        $userID = $this->userId[0]['userID'];
        $userIdInt = $userID + 0;
        $dateID = $this->travelTimeChoice;            
        $packagePrice = $totalPrice/$this->people;


        $this->invoice = new Invoice($this->userId, $packageID, $userIdInt, $packagePrice, $totalPrice, $this->people);



        $this->commands = new SqlCommands();
        $this->commands->connectDB();

        $sql = "INSERT INTO booked (packageID, userID, dateID, aantalPersonen, bedrag) VALUES(?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params
        
        $stmt = $this->commands->pdo->prepare($sql);
             
        if ($stmt) {
            $params = [$packageID, $userIdInt, $dateID, $this->people, $totalPrice];
            // var_dump($params);
            $stmt->execute($params);
            $this->invoice->genInvoice($packageID, $userIdInt, $packagePrice, $totalPrice);
            exit("boeking succesvol");
         }
    }
    
}
?>