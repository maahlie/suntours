<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'composer/vendor/autoload.php';
//require 'C:\xampp\composer\vendor\autoload.php';

class Mail {

    private $body;
    private $mail;
    private $subject;
    private $targetEmail;

    public function __construct($body, $subject, $targetEmail)
    {
        $this->mail = new PHPMailer(true);
        $this->body = $body;
        $this->subject = $subject;
        $this->targetEmail = $targetEmail;

            //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                        //Send using SMTP
        $this->mail->Host       = 'smtp-relay.sendinblue.com';        //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                               //Enable SMTP authentication
        $this->mail->Username   = 'SunTours.devOps@hotmail.com';      //SMTP username
        $this->mail->Password   = 'h1MmETC7zy6DbKtf';                 //SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 587;
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mail->setFrom('SunTours.devOps@hotmail.com', 'SunTours');

    }

    //Create an instance; passing `true` enables exceptions
    public function email(){
            //Recipients
            $this->mail->addAddress($this->targetEmail);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $this->subject;
            $this->mail->Body    = $this->body;
            $this->mail->AltBody = strip_tags($this->body);
        
            // $this->mail->send();

            return;
    }

}







