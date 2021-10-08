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

        $active = $userClass->getActivation($usernameLogin, $passwdLogin);

        $correct = $userClass->userPassCheck($usernameLogin, $passwdLogin);

        if($active["active"] == 0 && $correct == 0){
            exit("Gebruikersnaam of wachtwoord klopt niet.");
        }elseif($active["active"] == 1){
            $userClass->login($correct, $usernameLogin);
            if(isset($_SESSION['loggedIn'])){
                exit("U bent ingelogd, welkom " . $_SESSION['username']);
            }
        }else{
            exit('Uw account is nog niet geactiveerd, voer a.u.b eerst de code in.');
        }
    }
}

if (isset($_POST['reistijden']) && isset($_POST['AantalVolwassenen']) && isset($_POST['AantalKinderen']) && isset($_POST['packageID'])) {
    if(isset($_SESSION['loggedIn'])){
        if($_SESSION['loggedIn']==true){
                    $booking = new Booking($_POST['AantalVolwassenen'], $_POST['AantalKinderen'], $_POST['packageID'], $_POST['reistijden']);
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

if(isset($_POST['activateCode'])){
    $email = $_POST['email'];
    $actCode = $_POST['activateCode'];
    $correct = 1;

                $check = $userClass->activateUser($email, $actCode);

                switch($check){
                    case 1:                     
                        $userClass->loginActivate($correct, $email);
                        exit("Uw account is geactiveerd en u bent ingelogd.");

                    case 2:
                        exit("De code was onjuist.");

                    case 3:
                        exit("Het email adres was onjuist.");
                }
}


exit("Deze actie is niet bij ons bekend (404)"); //Foutafhandelig