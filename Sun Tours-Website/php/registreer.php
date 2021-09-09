<?php
try {

    if (isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['Vnaam']) && isset($_POST['Anaam']) && isset($_POST['usern']) && isset($_POST['passwd2']) && isset($_POST['passwd3'])) {

        $dsn = 'mysql:host=localhost;dbname=suntours'; //verbinding db
        $pdo = new PDO($dsn, 'suntoursroot', 'root'); //login op db
        $pdo->exec('SET CHARACTER SET UTF8');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);



        $sql = "INSERT INTO users (username, email, passwrd, telefoonnum, voornaam, achternaam) VALUES(?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params

        $stmt = $pdo->prepare($sql);

        if ($stmt) {
            $params = [$username, $email, $passwrd, $telefoonnum, $voornaam, $achternaam];
            $stmt->execute($params);
        }

        header("Location: ../aanmelden.html", TRUE, 303);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
