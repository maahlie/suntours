<?php

include 'user.php';
include 'dbClass.php';
include 'boekingen.php';
include 'mail.php';
$userClass = new User(); //functie afhandelen
session_start();

if (
    isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['firstName'])
    && isset($_POST['surName']) && isset($_POST['usern']) && isset($_POST['passwd2']) && isset($_POST['passwd3'])
) {
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

if (isset($_POST['usernLogin']) && isset($_POST['passwdLogin'])) {
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

if (isset($_POST['reistijden']) && isset($_POST['AantalVolwassenen']) && isset($_POST['AantalKinderen']) && isset($_POST['packageID'])) {
    if(isset($_SESSION['loggedIn'])){
        if($_SESSION['loggedIn']==true){
                    $booking = new Booking($_POST['AantalVolwassenen'], $_POST['AantalKinderen'], $_POST['packageID'], $_POST['reistijden'], $_POST['totalPrice'],$_POST['ticketPrice'],$_POST['carAmount'],$_POST['carPrice'],$_POST['busTicketAmount'],$_POST['busPrice']);
                    $booking->confirmOrder();
                    exit("boeking niet succesvol!!11!");
        }
    }else{
        exit('U bent nog niet ingelogd.');
    }
}

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

if (isset($_POST['contact_naam']) && isset($_POST['contact_email']) && isset($_POST['contact_onderwerp']) && isset($_POST['contact_text'])) {
    $email = $_POST['contact_email'];
    $contactSubject = $_POST['contact_onderwerp'];
    $contactBody = $_POST['contact_text'];
    $contactName = $_POST['contact_naam'];

    $userClass->contact($email,$contactBody,$contactSubject,$contactName);
}

if (isset($_POST['holidays']) && isset($_POST['rating']) && isset($_POST['titel']) && isset($_POST['review']) && isset($_POST['keuze'])) {
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

if(isset($_POST['activateCode'])){
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


exit("Deze actie is niet bij ons bekend (404)"); //Foutafhandelig
