<?php
include 'user.php';
include 'dbClass.php';
session_start();
$SESSION['userClass'] = new User();
$SESSION['userClass']->showReview(false);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sun Tours</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/Review_Cards.css">
    <link rel="stylesheet" href="../css/Review_page.css">
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Javascript/Review_Cards.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="../Javascript/ajax.js"></script>
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
    <script>
        Weglot.initialize({
            api_key: 'wg_e0862d6fccddf79b84908b2ed4ee35a62'
        });
    </script>
</head>

<body class="Review_Background">


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
                    <a class="nav-link" href="./Review.php">Review</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="boekingsGeschiedenis.php">boekingen overzicht</a>
                </li>
                <li class="nav-item" id='logout_li'>
                    <form method="POST" id="logoutForm">
                        <input type="submit" id="logout" name="logout" value="Log uit" class="btn btn-sm btn-outline-secondary">
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="Reviewheader">
        <h1>Review</h1>
    </div>
    <div class="reviewHeaderList">

        <main>

            <form method="POST" id="reviewForm">
                <div class="review-form">
                    <br>
                    <b> U moet ingelogd zijn om een review te kunnen schrijven.</b><br><br>
                    <label for="Holiday">Welke vakantie wilt u reviewen:</label><br>
                    <select name="holidays" class="select" id="holidays">
                        <option value="Spanje">Hotel Best Tenerife-Spanje </option>
                        <option value="Egypte">Hotel Hilton Marsa Resort -Egypte</option>
                        <option value="Turkije">Hotel Pine Bay Holiday Resort –Turkije</option>
                        <option value="Turkije2">Hotel Gold City -Turkije</option>
                        <option value="Frankrijk">Disneyland® Paris </option>

                    </select>

                    <br>
                    <br>
                    <label for="Waardering">Geef de vakantie een score:</label><br><br>
                    <div class="container d-flex justify-content-center mt-100">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                    <fieldset class="rating">
                                        <input type="radio" id="star5" name="rating" value="5" /><label class="full" for="star5" title="Perfect - 5 stars"></label>
                                        <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Erg goed - 4.5 stars"></label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label class="full" for="star4" title="Goed - 4 stars"></label>
                                        <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Voldoende - 3.5 stars"></label>
                                        <input type="radio" id="star3" name="rating" value="3" /><label class="full" for="star3" title="Goed genoeg - 3 stars"></label>
                                        <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kan beter - 2.5 stars"></label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label class="full" for="star2" title="Beetje slecht - 2 stars"></label>
                                        <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Slecht- 1.5 stars"></label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label class="full" for="star1" title="heel erg slecht - 1 star"></label>
                                        <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Verschrikkelijk - 0.5 stars"></label>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <label for="titel">Onderwerp:</label><br>
                    <input type="text" class="input" id="titel" name="titel"><br>
                    <br>



                    <label for="titel">Review:</label><br>
                    <textarea id="review" class="textarea" name="review" rows="4" cols="50"></textarea>
                    <br>
                    <br>
                    <label>Zou u deze website aanbevelen?</label>
                    <br>

                    <input type="radio" id="keuze" name="keuze" value="ja">
                    <label for="ja">Ja</label><br>
                    <input type="radio" id="keuze2" name="keuze" value="nee" checked>
                    <label for="nee">Nee</label><br>
                    <br>
                    <input type="submit" class="buttonReview" name="sendReview" value="verstuur">

                </div>

            </form>

            <div class="items">
                <?php
                for ($i = 1; $i < ($SESSION['userClass']->reviewLength) + 1; $i++) {
                    if ($SESSION['userClass']->arrayReview[$i][2])
                ?>
                    <div class="card" id='review'>
                        <div class="card-body" id='review_<?php echo $i ?>'>
                            <h4 class="card-title"><img src="https://img.icons8.com/ultraviolet/40/000000/quote-left.png"> </h4>
                            <div class="template-demo">
                                <p><?php echo $SESSION['userClass']->arrayReview[$i][1] ?></p>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2"> <img class="profile-pic" src="https://img.icons8.com/bubbles/100/000000/edit-user.png"> </div>
                                <div class="col-sm-10">
                                    <div class="profile">
                                        <h4 class="cust-name"><?php echo $SESSION['userClass']->arrayReview[$i][2] ?></h4>
                                        <p class="cust-profession"><?php echo $SESSION['userClass']->arrayReview[$i][3] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
        </main>
    </div>

</body>

<!-- footer is ook onderverdeeld in een top footer en voor de copyright een bottom footer -->

<!-- start topfooter -->
<footer id="ReviewFooter">
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