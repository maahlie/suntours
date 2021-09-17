<?php

// include 'dbClass.php';
// include 'user.php';
// // include 'registreer.php';

// session_start();

// if(isset($_SESSION['user'])){
//   $user = $_SESSION['user'];
// } else {
//   $_SESSION['user'] = new User();
//   $user = $_SESSION['user'];
// }

//         if($user->showMsg==true){
//           echo  'here';
//           $message="wachtwoorden matchen niet!";

//           echo "<script type='text/javascript'>alert('$message');</script>";

//           $user->showMsg=false;
//         }

//         if($user->showMsgEmail==true){

//           $message="Er is al een account geregistreerd met dit e-mail adres reeeeee!";

//           echo "<script type='text/javascript'>alert('$message');</script>";

//           $user->showMsgEmail=false;
//         }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sun Tours</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <script src="../node_modules/jquery/dist/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script src="../Javascript/registreer.js"></script>


</head>

<body>


  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a href="../index.html"><img class="img-fluid" src="../images/SunLogo.png" alt="x" style="width: 60px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="assortiment.html">Assortiment</a>
        </li>    
        <li class="nav-item">
          <a class="nav-link" href="boekingen.html">Boekingen</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.html">Contact</a>
        </li>
  
        <li class="nav-item">
          <a class="nav-link" href="aanmelden.html">Aanmelden</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="FAQ.html">FAQ</a>
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
          <img src="../images/SunLogo.png" id="icon" alt="Profiel
      " />
        </div>
        <form method="POST" id="loginpage" action="../Sun Tours-Website/php/inlog_check.php">
          <label>Gebruikersnaam</label><br>
          <input type="text" id="login" name="usern" placeholder="login"><br><br>
          <label>Wachtwoord</label><br>
          <input type="password" id="wachtwoord" name="passwd" placeholder="wachtwoord" minlength="8"><br><br>
          <input type="submit" value="Log In" id="loginKnop" class="sendKnop">
        </form>
      </div>
      <!-- <div class="c-form__progress"></div> -->
      <div class="formContent" id="registreerForm">
        <h2 class="actief"> Registreren </h2>

        <div class="fadeIn first">
          <img src="../images/SunLogo.png" id="icon" alt="Profiel
      " />
        </div>
        <form method="POST" id="registreerpage" action="ajaxHandler.php">
          <label>E-mail</label><br>
          <input type="email" id="email" name="email" placeholder="email@email.com" minlength="8"><br><br>
          <label>Telefoonnummer</label><br>
          <input type="text" id="phonenumber" name="phonenumber" placeholder="0123456789" minlength="10"><br><br>
          <label>Voornaam</label><br>
          <input type="text" id="firstName" name="firstName" placeholder="Voornaam"><br><br>
          <label>Achternaam</label><br>
          <input type="text" id="surName" name="surName" placeholder="Achternaam"><br><br>
          <label>Gebruikersnaam</label><br>
          <input type="text" id="usern" name="usern" placeholder="Gebruikersnaam"><br><br>
          <label>Adres (straatnaam + nummer)</label><br>
          <input type="text" id="address" name="address" placeholder="Adres"><br><br>
          <label>Postcode</label><br>
          <input type="text" id="postalCode" name="postalCode" placeholder="Postcode"><br><br>
          <label>Wachtwoord</label><br>
          <input type="password" id="passwd2" name="passwd2" placeholder="Wachtwoord"><br><br>
          <label>Bevestig wachtwoord</label><br>
          <input type="password" id="passwd3" name="passwd3" placeholder="Bevestig wachtwoord"><br><br>
          <input type="submit" value="Registreer" id="registratieknop" class="sendKnop">
        </form>
      </div>
    </div>
  </main>


</body>

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
          <a href=""><img class="img-fluid" src="../images/facebook.png" alt="x" style="width: 60px;"></a>
          <a href=""><img class="img-fluid" src="../images/twitter.png" alt="x" style="width: 60px;"></a>
          <div class="mt-1 mx-1">
            <a href=""><img class="img-fluid" src="../images/youtube.png" alt="x" style="width: 53px;"></a>
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