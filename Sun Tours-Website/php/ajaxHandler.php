<?php

include 'user.php';
include 'dbClass.php';
include 'boekingen.php';
include 'mail.php';

$userClass = new User();

session_start();

//registratie
if (isset($_POST['sendReg'])) {
    //If statement voor elke action (zorgt ervoor dat alle ajax in een file kan)

    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $firstName = $_POST['firstName'];
    $surName = $_POST['surName'];
    $usern = $_POST['usern'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $passwd = $_POST['passwd2'];
    $passwd2 = $_POST['passwd3'];

    $userClass->enterReg(
        $email,
        $phonenumber,
        $firstName,
        $surName,
        $usern,
        $address,
        $postalCode,
        $passwd,
        $passwd2
    );
    
    exit("Registreren is gelukt.");
}

//login
if (isset($_POST['sendLogin'])) {
    if (isset($_SESSION['loggedIn'])) {
        exit('U bent al ingelogd, ' . $_SESSION['username']);
        
    } else {

        $usernameLogin = $_POST['usernLogin'];
        $passwdLogin = $_POST['passwdLogin'];


        $check = $userClass->userLoginCheck($usernameLogin, $passwdLogin);

        switch($check){
            case 1:                     
                $userClass->login($usernameLogin);
                exit("U bent ingelogd.");
                break;

            case 2:
                exit("Uw account is nog niet geactiveerd.");
                break;

            case 3:
                exit("Uw gebruikersnaam of wachtwoord is onjuist.");
                break;

            default:
                exit("Deze actie is niet bij ons bekend (404).");
                break;
        }
    }
}

//boeking
if (isset($_POST['sendBoeking'])) {
    if(isset($_SESSION['loggedIn'])){
        if($_SESSION['loggedIn']==true){

                    $booking = new Booking(
                        $_POST['AantalVolwassenen'],
                        $_POST['AantalKinderen'],
                        $_POST['packageID'],
                        $_POST['reistijden'],
                        $_POST['totalPrice'],
                        $_POST['ticketPrice'],
                        $_POST['airlines'],
                        $_POST['carAmount'],
                        $_POST['carPrice'],
                        $_POST['rentalCarDays'],
                        $_POST['busTicketAmount'],
                        $_POST['busPrice'],
                        $_POST['busDays']
                    );

                    $booking->confirmOrder();
                   
                    exit("boeking niet succesvol!!!");
        }
    }else{
        exit('U bent nog niet ingelogd.');
    }
}

//logout
if(isset($_POST['logout'])){
    if(isset($_SESSION['loggedIn'])){
        if($_SESSION['loggedIn']==true){
                $userClass->logout();
                exit("U bent uitgelogd.");
        }
    }else{
        exit('U bent nog niet ingelogd.');
    }
}

//contactform
if (isset($_POST['sendContact'])) {
    $email = $_POST['contact_email'];
    $contactSubject = $_POST['contact_onderwerp'];
    $contactBody = $_POST['contact_text'];
    $contactName = $_POST['contact_naam'];
    $userClass->enterContact($contactName, $email, $contactSubject, $contactBody);
    $userClass->contact($email, $contactBody, $contactSubject, $contactName);
}

//review
if (isset($_POST['sendReview'])) {
    $packageId = $_POST['holidays'];
    $score = $_POST['rating'];
    $reviewSubject = $_POST['titel'];
    $review = $_POST['review'];
    $reccomendation = $_POST['keuze'];
    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }else{
        $username = '-';
    }
    

    $userClass->enterReview($packageId, $score, $reviewSubject, $review, $reccomendation, $username);

}

//account activatie
if(isset($_POST['verifyButtonAct'])) {
    $email = $_POST['email'];
    $actCode = $_POST['activateCode'];
    $correct = 1;

                $check = $userClass->activateUser($email, $actCode);

                switch($check){
                    case 1:                     
                        $userClass->loginActivate($correct, $email);
                        exit("Uw account is geactiveerd en u bent ingelogd.");
                        break;

                    case 2:
                        exit("De code was onjuist.");
                        break;

                    case 3:
                        exit("Het email adres was onjuist.");
                        break;

                    default:
                        exit("Deze actie is niet bij ons bekend (404).");
                        break;
                }
}

//code sturen voor veranderen wachtwoord
if(isset($_POST['sendCodeButton'])) {
    $email = $_POST['codeEmail'];
    $userClass->codeEmailSend($email);
    exit("Email met code verstuurd.");  
}

//verander wachtwoord
if(isset($_POST['verifyButton'])) {
    $email = $_POST['pswrdEmail'];
    $newPass = $_POST['newPswrd'];
    $code = $_POST['secCode'];

    $userClass->changePassword($newPass, $email, $code);
    exit('Uw wachtwoord is succesvol veranderd.');
}

exit("Deze actie is niet bij ons bekend (404)"); //Foutafhandelig