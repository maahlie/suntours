<?php

include 'user.php';
include 'dbClass.php';
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

        $userClass->login($usernameLogin,$passwdLogin);

        if (isset($_SESSION['loggedIn'])) {
            exit("U bent ingelogd, welkom " . $_SESSION['username']);

        } else {
            exit("Gebruikersnaam of wachtwoord klopt niet.");

        }
    }
}
exit("Deze actie is niet bij ons bekend (404)"); //Foutafhandelig
