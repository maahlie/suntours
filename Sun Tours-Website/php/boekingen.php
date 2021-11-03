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
    public function __construct($adults, $kids, $id, $travelTimeChoice, $packagePrice, $ticketPrice, $carAmount, $carPrice, $rentalCarDays, $busTicketAmount, $busPrice, $busDays)
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

        $sql = "SELECT dateID FROM booked WHERE dateID = 1";
        $stmt = $this->commands->pdo->prepare($sql);

        $stmt->execute();
        $dateID1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT dateID FROM booked WHERE dateID = 2";
        $stmt = $this->commands->pdo->prepare($sql);

        $stmt->execute();
        $dateID2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT dateID FROM booked WHERE dateID = 3";
        $stmt = $this->commands->pdo->prepare($sql);

        $stmt->execute();
        $dateID3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $maxPersonen = 0;

        $dateId = $_POST['reistijden'];
        $country = $_POST['packageID'];
        
        if ($country == 'Spanje')           {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Turkije1')  {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Turkije2')  {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Egypte')    {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            }
        } else if ($country == 'Frankrijk') {
            if ($dateId == '1') {
                for($i = 0; $i < sizeof($dateID1); $i++) {
                    $maxPersonen += $dateID1[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '2') {
                for($i = 0; $i < sizeof($dateID2); $i++) {
                    $maxPersonen += $dateID2[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            } else if ($dateId == '3') {
                for($i = 0; $i < sizeof($dateID3); $i++) {
                    $maxPersonen += $dateID3[$i]['dateID'];
                    if($maxPersonen >= 24) {
                        exit("Er zijn al te veel boekingen!");
                    } 
                }
                return $this->confirmOrder();
            }
        }
    }
}
?>