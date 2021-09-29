<!DOCTYPE html>
<html lang="en" class="registreer_html">

<head>
  <title>Sun Tours</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="../Javascript/aameld_box_size.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <script src="../node_modules/jquery/dist/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script src="../Javascript/registreer.js"></script>
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>

<body class="registreer_body">

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a href="../index.html"><img class="img-fluid" src="../images/SunLogo.png" alt="x" style="width: 60px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../assortiment.html">Assortiment</a>
        </li>    
        <li class="nav-item">
          <a class="nav-link" href="../contact.html">Contact</a>
        </li>
  
        <li class="nav-item">
          <a class="nav-link" href="./aanmelden.php">Aanmelden</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="../FAQ.html">FAQ</a>
        </li> 
        <li class="nav-item">
                    <a class="nav-link" href="../Review.html">Review</a>
                </li>
      </ul>
    </div>  
  </nav>

  <main>
    <div class="row">
        <div class="col-md-6 mx-auto p-0">
            <div class="card">
                <div class="login-box" id="login_id">
                    <div class="login-snip"> <input id="tab-1" type="radio" name="tab" class="sign-in" checked onclick="document.getElementById('login_id').style.height = '600px'"><label for="tab-1" class="tab">Login</label> <input id="tab-2" type="radio" name="tab" class="sign-up" onclick="document.getElementById('login_id').style.height = '1200px'" ><label for="tab-2" class="tab">Registreer</label>
                        <div class="login-space">
                            <div class="login">
                            <form method="POST" id="loginPage">
                                <div class="group"> <label for="user" class="label">Gebruikersnaam</label> <input type="text" id="usernLogin" name="usernLogin" placeholder="login" class="input"> </div>
                                <div class="group"> <label for="pass" class="label">Wachtwoord</label> <input type="password" id="passwdLogin" name="passwdLogin" placeholder="wachtwoord" minlength="1" class="input"> </div>
                                <div class="group"> <input id="check" type="checkbox" class="check" checked> <label for="check"><span class="icon"></span> Ingelogd blijven</label> </div>
                                <div class="group"> <input type="submit" value="Log In" id="loginKnop" class="sendKnop button"> </div>
                                <div class="hr"></div>
                                <div class="foot"> <a href="#">Wachtwoord vergeten?</a> </div>
                              </form>
                            </div>
                            <div class="sign-up-form">
                            <form method="POST" id="registreerpage" >
                                <div class="group"> <label for="user" class="label">Gebrukersnaam</label> <input type="text" id="usern" name="usern" placeholder="Gebruikersnaam" class="input"> </div>
                                <div class="group"> <label for="user" class="label">Voornaam</label><input type="text" id="firstName" name="firstName" placeholder="Voornaam" class="input"></div>
                                <div class="group"> <label for="user" class="label">Achternaam</label><input type="text" id="surName" name="surName" placeholder="Achternaam" class="input"></div>

                                <div class="group"> <label for="user" class="label">Voornaam</label><input type="text" id="address" name="address" placeholder="Adres" class="input"></div>
                                <div class="group"> <label for="user" class="label">Achternaam</label><input type="text" id="postalCode" name="postalCode" placeholder="Postcode" class="input"></div>

                                <div class="group"> <label for="user" class="label">Telefoonnummer</label><input type="text" id="phonenumber" name="phonenumber" placeholder="0123456789" minlength="10" class="input"></div>
                                <div class="group"> <label for="pass" class="label">Wachtwoord</label> <input type="password" id="passwd2" name="passwd2" placeholder="Wachtwoord" class="input"> </div>
                                <div class="group"> <label for="pass" class="label">Herhaal wachtwoord</label> <input type="password" id="passwd3" name="passwd3" placeholder="Bevestig wachtwoord" class="input"> </div>
                                <div class="group"> <label for="pass" class="label">Email Address</label> <input type="email" id="email" name="email" placeholder="email@email.com" minlength="8" class="input"> </div>
                                <div class="group"> <input type="submit" value="Registreer" id="registratieknop" class="sendKnop button"> </div>
                                <div class="hr"></div>
                                <div class="foot"> <label for="tab-1">Bent u al geregistreerd?</label> </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>
</body>

<footer id="aanmelden_footer">
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
  <div class="bottomFooter">
    copyright &copy; 2021 <i>Ontworpen door: Thomas-Thomas-Stef-Lucas</i>
  </div>
</footer>
</html>