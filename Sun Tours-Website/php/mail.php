<?php
//Import PHPMailer classes into the global namespace.
//These must be at the top of your script, not inside a function.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader.
require 'composer/vendor/autoload.php';

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

        //Server settings.
        //the information you comes from the sendinblue.
        $this->mail->isSMTP();                                        //Send using SMTP.
        $this->mail->Host       = 'smtp-relay.sendinblue.com';        //Set the SMTP server to send through.
        $this->mail->SMTPAuth   = true;                               //Enable SMTP authentication.
        $this->mail->Username   = 'SunTours.devOps@hotmail.com';      //SMTP username.
        $this->mail->Password   = 'h1MmETC7zy6DbKtf';                 //SMTP password.
        $this->mail->Port       = 587;
       
        //setting the email adress where email will be send from and under which name.
        $this->mail->setFrom('SunTours.devOps@hotmail.com', 'SunTours');

    }

    public function email(){
            //here we say to which email adress the email needs to be send to.
            $this->mail->addAddress($this->targetEmail);
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $this->subject;                      //Set a subject
            $this->mail->Body    = $this->body;                         //Set the body
            $this->mail->AltBody = strip_tags($this->body);
        
            //actually sending the mail.
            $this->mail->send();

            return;
    }

    public function email2($pdf, $fileName){
        //here we say to which email adress the email needs to be send to.
        $this->mail->addAddress($this->targetEmail);    
    
        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = $this->subject;                      //Set a subject
        $this->mail->Body    = $this->body;                         //Set the body
        $this->mail->AltBody = strip_tags($this->body);

        //add the pdf
        $this->mail->AddStringAttachment($pdf, $fileName);

        //actually sending the mail.
        $this->mail->send();

        return;
}

}







