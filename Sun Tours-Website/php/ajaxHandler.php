<?php

include 'user.php';
include 'dbClass.php';

if (isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['firstName'])
&& isset($_POST['surName']) && isset($_POST['usern']) && isset($_POST['passwd2']) && isset($_POST['passwd3'])){
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

    $userClass = new User(); //functie afhandelen
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

if (isset($_POST['usernLogin']) && isset($_POST['passwdLogin'])){

    $usernameLogin = $_POST['usernLogin'];
    $passwdLogin = $_POST['passwdLogin'];
    
    $userClass->login(
        $usernameLogin,
        $passwdLogin
    );

    exit("u bent ingelogd.");
}


exit("Deze actie is niet bij ons bekend (404)"); //Foutafhandelig
?>