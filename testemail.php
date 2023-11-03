
<?php
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'vendor/autoload.php';
 
$mail = new PHPMailer(true);
$pin = 123321;
 
try {
    $mail->SMTPDebug = 0;                                       
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com;';                    
    $mail->SMTPAuth   = true;                             
    $mail->Username   = 'iclothfyp@gmail.com';                 
    $mail->Password   = 'iiprgvqfjvhegsle';                        
    $mail->SMTPSecure = 'tls';                              
    $mail->Port       = 587;  
 
    $mail->setFrom('asd@gmail.com', 'asd');           
    $mail->addAddress('kaibutsu740@gmail.com');
      
    $mail->isHTML(true);                                  
    $mail->Subject = 'Subject';
    $mail->Body    = '                        <h2>You are Attempting to Login in iCloth PHP Web Application</h2>
    <p>Here is your OTP (One-Time PIN) to verify your Identity.</p>
    <h3><b>' . $pin . '</b></h3>';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
 
?>