<?php

class Invoice {
    private $commands;
    public $today;
    public $mail;
    public $targetEmail;
    public $invoiceNmbr;
    private $total;
    private $vat;
    private $userID;
	private $bookingID;
	private $packageID;
	private $userIdInt;
	private $packagePrice;
	private $totalPrice;
	private $people;
	private $ticketPrice;
    private $carAmount;
    private $carPrice;
    private $busTicketAmount;
    private $busPrice;

    public function __construct($userID, $packageID, $userIdInt, $packagePrice, $people, $ticketPrice, $carAmount, $carPrice, $busTicketAmount, $busPrice, $rentalCarDays, $busDays)
    {
        $this->userID = $userID;
        $this->userInvoice = new User();
        $this->commands = new SqlCommands();
        $this->commands->connectDB();
        $this->total = 0;
        $this->vat = 0.21;
		$this->bookingID = $this->getBookingID();
		$this->invoiceNmbr = $this->genInvoiceNr($userIdInt);
		$this->packageID = $packageID;
        $this->userIdInt = $userIdInt;
        $this->packagePrice = $packagePrice;
		$this->ticketPrice = $ticketPrice; 
		$this->carAmount = $carAmount; 
		$this->carPrice = $carPrice;
		$this->busTicketAmount = $busTicketAmount;
		$this->busPrice = $busPrice;
		$this->people = $people;
		$this->busDays = $busDays;
        $this->rentalCarDays = $rentalCarDays;

        // $this->totalPrice = $totalPrice;
		$this->finalPrices = $this->calcFinalPrice();

        $this->articles = array(
            array("Pakket prijs","vlucht","Autoverhuur","BusDeal"),
            array($people,$people,$this->carAmount,$this->busTicketAmount),
            array($this->packagePrice,$this->ticketPrice,$this->carPrice*$this->rentalCarDays,$this->busPrice*$this->busDays)
    );

    }

	public function getBookingID(){
		$userID =  $this->userID;
		$userID = $userID + 0;
		$bookingID = $this->commands->selectOrderDesc($userID);
		return $bookingID[0]['bookingID'];
	}

	private function calcFinalPrice(){
        $packagePriceFull = $this->people * $this->packagePrice;
        $ticketPrice =  $this->people * $this->ticketPrice;
        $carPrice =  $this->carAmount * $this->rentalCarDays * $this->carPrice;
        $busPrice = $this->busTicketAmount * $this->busPrice * $this->busDays; 
        
        $finalPrices = array(
            $packagePriceFull,
            $ticketPrice,
            $carPrice,
            $busPrice
        );

        return $finalPrices;
    }

    public function getNames(){
        $firstName = $this->commands->selectFromWhere("firstName", "users", "userID", $this->userIdInt);
        $surName = $this->commands->selectFromWhere("surName", "users", "userID", $this->userIdInt);
        $fullName = $firstName[0]['firstName'] . " " . $surName[0]['surName'];
        return $fullName;
    }

	// public function getPackPrice(){
	// 	$packageID = $this->commands->selectFromWhere("packageID", "booked", "bookingID", $this->bookingID);
	// 	$packetPrice = $this->commands->selectFromWhere("price", "packages", "packageID", $packageID[0]['packageID']);
	// 	return $packetPrice[0]['price'];
	// }

	// public function getTotalPackPrice()
	// {
	// 	$totalPrice = $this->commands->selectFromWhere("bedrag", "booked", "bookingID", $this->bookingID);
	// 	var_dump($totalPrice);
	// 	return $totalPrice[0]['bedrag'];
	// }

	public function getStreet(){
		$streetName = $this->commands->selectFromWhere("address", "users", "userID", $this->userID);
		return $streetName[0]['address'];
	}

	public function getPostal(){
		$postalCode = $this->commands->selectFromWhere("postalcode", "users", "userID", $this->userID);
		return $postalCode[0]['postalcode'];
	}

    public function getDate(){
        $today = date('d-m-y');
        return $today;
    }

	public function genInvoiceNr($userIdInt){
		$invoiceNr = $userIdInt . "0" . $this->bookingID;
		return $invoiceNr;
	}

    public function sendMail($targetEmail,$completeBody,$mailSubject){
        $this->userInvoice->confMail($targetEmail,$completeBody,$mailSubject);
    }

    public function forFill(){
        $printFor = "";
        for($i=0;$i<4;$i++) {
            $description = $this->articles[0][$i];
            $amount = $this->articles[1][$i];
            $unit_price = $this->articles[2][$i];
            $total_price = $amount * $unit_price;
            $printFor .= "<tr>";
            $printFor .= "<td>$description</td>";
            $printFor .= "<td class='text-center'>".$amount."</td>";
            $printFor .= "<td class='text-right'>"."&euro;".number_format($unit_price, 2)."</td>";
            $printFor .= "<td class='text-right'>"."&euro;".number_format($total_price, 2)."</td>";
            $printFor .= "</tr>";
			$this->total += $total_price;
        }

        return $printFor;
    }

    public function genInvoice()
    {
        $invoiceBody = 
'<html>
	<head>  
        <title>Simple invoice in PHP</title>
        <!-- <script type="text/javascript" src="Javascript/aameld_box_size.js"></script> -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
        <!-- <link rel="stylesheet" href="css/styles.css"> -->
        <!-- <script src="node_modules/jquery/dist/jquery.js"></script> -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
        <!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
        <!-- <script src="../Javascript/ajax.js"></script> -->
        <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
	
		<style type="text/css">
		body {		
			font-family: Verdana;
		}
		
		div.invoice {
		border:1px solid #ccc;
		padding:10px;
		height:740pt;
		width:570pt;
		}

		div.company-address {
			border:1px solid #ccc;
			float:left;
			width:200pt;
		}
		
		div.invoice-details {
			border:1px solid #ccc;
			float:right;
			width:200pt;
		}
		
		div.customer-address {
			border:1px solid #ccc;
			float:right;
			margin-bottom:50px;
			margin-top:100px;
			width:200pt;
		}
		
		div.clear-fix {
			clear:both;
			float:none;
		}
		
		table {
			width:100%;
		}
		
		th {
			text-align: left;
		}
		
		td {
		}
		
		.text-left {
			text-align:left;
		}
		
		.text-center {
			text-align:center;
		}
		
		.text-right {
			text-align:right;
		}
		
		</style>
	</head>

	<body>
	<div class="invoice">
		<div class="company-address">
			Sun Tours
			<br />
			Bredeweg 235
			<br />
			6042 GE, Roermond
			<br />
		</div>
	
		<div class="invoice-details">
			Invoice N&deg;: ' . $this->invoiceNmbr . '          
			<br />
			Date:'. $this->getDate() . '
		</div>

		<div class="customer-address">
			To:
			<br />
			'. $this->getNames() . '
			<br />
			'. $this->getStreet() .'
			<br />
			London, '. $this->getPostal() .'
			<br />
		</div>
		
		<div class="clear-fix"></div>
       
			<table border="1" cellspacing="0">
				<tr>
					<th width=250>Beschrijving</th>
					<th width=80>Aantal keren</th>
					<th width=100>Bedrag per stuk</th>
					<th width=100>Totaal price</th>
				</tr>			

            ' . $this->forFill() . '
            
			<tr>
			<td colspan='."3".' class='."text-right".'>Sub total</td>
			<td class='."text-right".'>&euro;' . number_format($this->total,2) . '</td>
			</tr>
			<tr>
			<td colspan='."3".' class='."text-right".'>VAT</td>
			<td class='."text-right".'>&euro;' . number_format(($this->total*$this->vat),2) . '</td>
			</tr>
			<tr>
			<td colspan='."3".' class='."text-right".'><b>TOTAL</b></td>
			<td class='."text-right".'><b>&euro;' . number_format(((($this->total*$this->vat))+$this->total),2) . '</b></td>
		    </tr>
			</table>
		</div>
	</body>   
</html>
';


$targetEmail = 'SunTours.devOps@hotmail.com';
$completeBody = $invoiceBody;
$mailSubject = "Vactuur";

$this->sendMail($targetEmail,$completeBody,$mailSubject);
    }

 
    
}
?>
