<?php
    session_start();
    //primary key moet auto increment zijn!!!! :)

    if (isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['Vnaam']) && isset($_POST['Anaam']) && isset($_POST['usern']) && isset($_POST['passwd2']) && isset($_POST['passwd3'])) {
        
        if($_POST['passwd2'] != $_POST['passwd3']){
            $_SESSION['showMsg'] = true;
            header("Location: ../aanmelden.php", TRUE, 303);
            exit;
        }

        // $dsn = 'mysql:host=localhost;dbname=suntours';
        $pdo = new PDO('mysql:host=localhost;dbname=suntours', 'suntoursroot', 'root'); //login op db
        $pdo->exec('SET CHARACTER SET UTF8');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $sql = "SELECT email FROM users;";
        $stmt = $pdo->prepare($sql);
        if ($stmt) {
            $params = [1];
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_NUM);
            print "<pre>";
            print_r($result);
            print "</pre>";        
        }

        for($i=0; $i<count($result); $i++){
            if($_POST['email']==$result[$i][0]){
                $_SESSION['showMsgEmail'] = true;
                header("Location: ../aanmelden.php", TRUE, 303);
                exit;
            }
        }


        $username = trim(htmlentities($_POST['usern']));
        $email = trim(htmlentities($_POST['email']));
        $passwrd = trim(htmlentities($_POST['passwd2']));
        $passwordCtrl = trim(htmlentities($_POST['passwd3']));
        $voornaam = trim(htmlentities($_POST['Vnaam']));
        $achternaam = trim(htmlentities($_POST['Anaam']));
        $telefoonnum = trim(htmlentities($_POST['phonenumber']));

        $sql = "INSERT INTO users (username, email, passwrd, telefoonnum, voornaam, achternaam) VALUES(?, ?, ?, ?, ?, ?)"; //query, vraagtekens worden gevuld bij de execute met $params

        $stmt = $pdo->prepare($sql);

        if ($stmt) {
            $params = [$username, $email, $passwrd, $telefoonnum, $voornaam, $achternaam];
            $stmt->execute($params);
            echo $username;
        }

        header("Location: ../aanmelden.php", TRUE, 303);
    }

?>