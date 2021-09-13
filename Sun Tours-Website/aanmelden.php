<?php

session_start();
        if(!isset($_SESSION['showMsg'])){
          $_SESSION['showMsg']=false;
        }

        if(!isset($_SESSION['showMsgEmail'])){
          $_SESSION['showMsgEmail']=false;
        }

        if($_SESSION['showMsg']==true){

          $message="wachtwoorden matchen niet!";

          echo "<script type='text/javascript'>alert('$message');</script>";

          $_SESSION['showMsg']=false;

        }

        if($_SESSION['showMsgEmail']==true){

          $message="Er is al een account geregistreerd met dit e-mail adres reeeeee!";

          echo "<script type='text/javascript'>alert('$message');</script>";

          $_SESSION['showMsgEmail']=false;

        }
        

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sun Tours</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="Javascript/registreer.js"></script>
  
  <style>
  </style>
</head>

<body>


  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a href="index.html"><img class="img-fluid" src="images/SunLogo.png" alt="x" style="width: 60px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="boekingen.html">Boekingen</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.html">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="assortiment.html">Assortiment</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="aanmelden.html">Aanmelden</a>
        </li>
      </ul>
    </div>
  </nav>

  <main>
    <div class="c-form__progress"></div>
    <div class="wrapper Val">

      <div class="formContent" id="inlogForm">
        <h2 class="actief"> Inloggen </h2>

        <div class="fadeIn first">
          <img src="images/SunLogo.png" id="icon" alt="Profiel
      " />
        </div>
        <form method="POST" id="loginpage" action="/php/inlog_check.php">
          <label>Gebruikersnaam</label><br>
          <input type="text" id="usernLogIn" name="usern" placeholder="login" class="loginFocus"><br><br>
          <label>Wachtwoord</label><br>
          <input type="password" id="wachtwoordLogIn" name="passwd" class="loginFocus" placeholder="wachtwoord" minlength="8"><br><br>
          <input type="submit" value="Log In" id="loginKnop" class="sendKnop">
        </form>
      </div>
      <!-- <div class="c-form__progress"></div> -->
      <div class="formContent" id="registreerForm">
        <h2 class="actief"> Registreren </h2>

        <div class="fadeIn first">
          <img src="images/SunLogo.png" id="icon" alt="Profiel" />
        </div>
        <form method="POST" id="registreerpage" action="php/registreer.php">
          <label>E-mail</label><br>
          <input type="email" id="email" name="email" placeholder="email@email.com" required><br><br>
          <label>Telefoonnummer</label><br>
          <input type="text" id="phonenum" name="phonenumber" placeholder="0123456789" required><br><br>
          <label>Voornaam</label><br>
          <input type="text" id="Vnaam" name="Vnaam" placeholder="Voornaam" required><br><br>
          <label>Achternaam</label><br>
          <input type="text" id="Anaam" name="Anaam" placeholder="Achternaam" required><br><br>
          <label>Gebruikersnaam</label><br>
          <input type="text" id="usern" name="usern" placeholder="Gebruikersnaam" required><br><br>
          <label>Wachtwoord</label><br>
          <input type="password" id="passwd2" name="passwd2" placeholder="Wachtwoord" required><br><br>
          <label>Bevestig wachtwoord</label><br>
          <input type="password" id="passwd3" name="passwd3" placeholder="Bevestig wachtwoord" required><br><br>
          <input type="submit" value="Registreer" id="registratieknop" class="sendKnop">
        </form>
      </div>
    </div>
  </main>

</body>
<!-- action="php/registreer.php" -->
<!-- footer is ook onderverdeeld in een top footer en voor de copyright een bottom footer -->
<footer>
  <!-- start topfooter -->
  <div class="topFooter">
    <div class="row">
      <div class="col-5 mx-4 mb-1">
        <a>Suntours</a></br>
        <a>Bredeweg 235, 6042 GE Roermond</a></br>
        <a>06-13022010</a></br>
        <a>088 2365148</a></br>
      </div>
      <div class="col-3 mx-3 mt-3">
        <div class="row mx-1">
          <a href=""><img class="img-fluid" src="images/facebook.png" alt="x" style="width: 60px;"></a>
          <a href=""><img class="img-fluid" src="images/twitter.png" alt="x" style="width: 60px;"></a>
          <div class="mt-1 mx-1">
            <a href=""><img class="img-fluid" src="images/youtube.png" alt="x" style="width: 53px;"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- einde topfooter -->

  <!-- start bottom footer -->
  <div class="bottomFooter">
    copyright &copy; 2021 <i>Ontworpen door: Thomas-Thomas-Stef-Lucas</i>
  </div>
  <!-- bottom footer -->
</footer>

</html>