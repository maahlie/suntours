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
  <div class="card signup_v4 mb-30">
    <div class="card-body">
        <ul class="nav nav-tabs " id="myTab" role="tablist">
            <li class="nav-item" role="presentation"> <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a> </li>
            <li class="nav-item" role="presentation"> <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a> </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <h4 class="text-center mt-4 mb-4" style="text-transform: uppercase;">Login</h4>
                <form id="loginPage">
                    <div class="form-row">
                        <div class="form-group col-md-12"> <label for="user" class="label">Gebruikersnaam</label> <input type="text" id="usernLogin" name="usernLogin" placeholder="login" class="input" class="form-control"> </div>
                        <div class="form-group col-md-12"> <label for="pass" class="label">Wachtwoord</label> <input type="password" id="passwdLogin" name="passwdLogin" placeholder="wachtwoord" minlength="1" class="input"> </div>
                        <div class="form-group col-md-12">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                
                            </div>
                        </div>
                    </div>
                    <div class="foot"> <a href="#">Wachtwoord vergeten?</a> </div>
                    <div class="mt-2 mb-3"> <button class="btn btn-primary full-width sendKnop button"  value="Log In" id="loginKnop" type="submit">Login</button> </div>
                </form>
               
            </div>
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <h4 class="text-center mt-4 mb-4" style="text-transform: uppercase;">Registreer</h4>
                <form id="registreerpage">
                    <div class="form-row">
                        <div class="form-group col-md-12"><label for="user" class="label">Gebrukersnaam</label> <input type="text" class="form-control"  id="usern"  name="usern" placeholder="Gebruikersnaam" class="input"> </div>
                        <div class="form-group col-md-12"><label for="user" class="label">Voornaam</label><input type="text"  class="form-control" id="firstName" name="firstName" placeholder="Voornaam" class="input"></div>
                        <div class="form-group col-md-12"><label for="user" class="label">Achternaam</label><input type="text" class="form-control" id="surName" name="surName" placeholder="Achternaam" class="input"></div>
                       
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-12"><label for="user" class="label">PostCode</label><input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="Postcode" class="input"></div>
                    <div class="form-group col-md-12"><label for="user" class="label">Telefoonnummer</label><input type="text" class="form-control" id="phonenumber" name="phonenumber" placeholder="0123456789" minlength="10" class="input"></div>
                        <div class="form-group col-md-12"> <label for="user" class="label">Adres</label><input type="text" class="form-control" id="address" name="address" placeholder="Adres" class="input"></div>
                        <div class="form-group col-md-12"> <label for="pass" class="label">Wachtwoord</label> <input type="password"  class="form-control" id="passwd2" name="passwd2" placeholder="Wachtwoord" class="input"> </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">  <label for="pass" class="label">Herhaal wachtwoord</label> <input type="password" class="form-control" id="passwd3" name="passwd3" placeholder="Bevestig wachtwoord" class="input"> </div>
                        <div class="form-group col-md-12"> <label for="pass" class="label">Email Address</label> <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" minlength="8" class="input"> </div>
                              
                    </div>
                    <div class="form-group form-row mt-2">
                        <div class="col-md-10 pt-1">
                            <div class="form-check form-check-inline">   </div>
                            <div class="form-check form-check-inline">  </div>
                            <div class="form-check form-check-inline">  </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                    </div>
                   
                    <hr class="mt-3 mb-4">
                    <div class="col-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="custom-checkbox d-block"> </div> <button class="btn btn-primary mt-3 mt-sm-0 sendKnop button" value="Registreer" id="registratieknop" type="submit">Registreer</button>
                        </div>
                    </div>
                </form>
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