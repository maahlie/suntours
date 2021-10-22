<?php 
session_start();
  include 'user.php';
  include 'dbClass.php';
  include 'boekingen.php';
  include 'mail.php';

  
  if (isset($_SESSION['username'])){
  }else{
    header('Location: ../aanmelden.html');    
  }

  $userClass = new User;
  $userClass->getBookingValues($_SESSION['username']);
  

  

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
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="../Javascript/ajax.js"></script>
  <script type="text/javascript" src="../Javascript/url-search.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,200&display=swap" rel="stylesheet">
  <style>
    .fakeimg {
      height: 200px;
      background: #aaa;
    }
  </style>
  <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
  <script>
    Weglot.initialize({
      api_key: 'wg_e0862d6fccddf79b84908b2ed4ee35a62'
    });
  </script>

</head>

<body class="bg_Background" onload=boekingGeschiedenisLoad()>

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
          <a class="nav-link" href="../aanmelden.html">Aanmelden</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../FAQ.html">FAQ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../php/Review.php">Review</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../php/boekingsGeschiedenis.php">boekingen overzicht</a>
        </li>
        <li class="nav-item" id='logout_li'>
          <form method="POST" id="logoutForm">
            <input type="submit" id="logout" name="logout" value="loguit" class="btn btn-sm btn-outline-secondary">
          </form>
        </li>
      </ul>
    </div>
  </nav>
  <div class="header_bg">
    <h1>Boekingen overzicht</h1><br>
  </div>
  <main>
    <div class="table-responsive">
    <table class="table table-striped" id="boekingsOverzicht" style="display:none">
      <thead>
        <tr>
          <th scope="col">#</th>

          <th scope="col">Vakantie:</th>
          <th scope="col">Vlieg Tickets:</th>
          <th scope="col">Aantal auto's:</th>
          <th scope="col">Auto merk:</th>
          <th scope="col">Bus Tickets</th>
          <th scope="col">Begin Datum</th>
          <th scope="col">Eind Datum</th>
          <th scope="col">cancel</th>
        </tr>
      </thead>
      <tbody>
        <?php
          for ($i = 0; $i < $userClass->BookedVacationCount; $i++){
        ?>
        <tr>
        <th scope="row"><?php echo $i ?></th>
        <td><?php echo $userClass->BookedVacations[$i]['packageID'] ?></td>
        <td><?php echo $userClass->BookedVacations[$i]['aantalPersonen'] ?></td>
        <td><?php echo $userClass->BookedVacations[$i]['carAmount'] ?></td>
        <td><?php echo $userClass->BookedVacations[$i]['carBrand'] ?></td>
        <td><?php echo $userClass->BookedVacations[$i]['busTicketAmount'] ?></td>
        <td><?php echo $userClass->BookedVacations[$i]['startingDate'] ?></td>
        <td><?php echo $userClass->BookedVacations[$i]['returnDate'] ?></td>
        <td><button class="tableButton">annuleer</button></td>
      </tr>
      <?php
          }
        ?>
      </tbody>
    </table>
  </div>
  </main>
</body>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<footer id="bgFooter">
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