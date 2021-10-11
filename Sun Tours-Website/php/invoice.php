<?php


//$invoice = new Invoice($adults, $kids, $id, $travelTimeChoice);
$targetEmail;
$invoiceNmbr = 420;
$getDate = $invoice->getDate();
$fullName = $invoice->getNames();


$articles = array(
    array("Motherboard","Case","RAM","Hard Disk","Monitor", "Installation"),
    array(1,1,2,2,1,1),
    array(65,80,70,125,210,30)
);

$total = 0;
$vat = 21;

$forFill = $invoice->forFill($articles, $total);

?>

<?php 

$test = 
'<html>
	<head>  
        <title>Simple invoice in PHP</title>
        <!-- <script type="text/javascript" src="Javascript/aameld_box_size.js"></script> -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
        <!-- <link rel="stylesheet" href="css/styles.css"> -->
        <!-- <script src="node_modules/jquery/dist/jquery.js"></script> -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
        <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
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
        <!-- moet nog gegenereerd worden -->
			Invoice N°: ' . $invoiceNmbr . '          
			<br />
			Date:'. $getDate . '
		</div>
		
		<div class="customer-address">
			To:
			<br />
            <!-- moet uit db gehaald worden -->
			'. $fullName . '
			<br />
			123 Long Street
			<br />
			London, DC3P F3Z 
			<br />
		</div>
		
		<div class="clear-fix"></div>
       
			<table border="1" cellspacing="0">
				<tr>
					<th width=250>Beschrijving</th>
					<th width=80>Bedrag</th>
					<th width=100>Bedrag per stuk</th>
					<th width=100>Totaal price</th>
				</tr>			

            ' . $forFill . '
            
			<tr>
			<td colspan='."3".' class='."text-right".'>Sub total</td>
			<td class='."text-right".'>€' . number_format($total,2) . '</td>
			</tr>
			<tr>
			<td colspan='."3".' class='."text-right".'>VAT</td>
			<td class='."text-right".'>€' . number_format(($total*$vat)/100,2) . '</td>
			</tr>
			<tr>
			<td colspan='."3".' class='."text-right".'><b>TOTAL</b></td>
			<td class='."text-right".'><b>€' . number_format(((($total*$vat)/100)+$total),2) . '</b></td>
		    </tr>
			</table>
		</div>
	</body>   
</html>
';

echo $test;
$targetEmail = 'SunTours.devOps@hotmail.com';
$completeBody = $test;
$mailSubject = "test";

//$invoice->sendMail($targetEmail,$completeBody,$mailSubject);
?>
