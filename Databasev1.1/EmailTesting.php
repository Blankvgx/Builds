#!/usr/bin/php
<?php
require 'vendor/autoload.php'; //Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($userEmail,$title, $number){
//echo $number, "\n";
$mail = new PHPMailer(true);  // Create a new PHPMailer instance
//echo "SendEmail Message: ", $number, "\n";
//testing variables
//$userEmail = 'mws36@njit.edu';
//$title = 'Batman';

try {
    //Server settings
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'MoviCritics@gmail.com';               
    $mail->Password   = 'oduf fxlj drhd rbuc';                     
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
    $mail->Port       = 587;                           
    //Recipients
    $mail->setFrom('MoviCritics@gmail.com', 'MoviCritics'); //We're sending the movie
    //$mail->addAddress('mws36@njit.edu');
    $mail->addAddress($userEmail);//Address we're sending it to.

    // Content for the email
    $mail->isHTML(true);                                      
    $mail->Subject = 'MoviCritics: A movie on your watchlist released!';
	$mail->Body = "Hello! A movie on your watchlist has been released: $title!";
    $mail->send();
    
    echo 'Email sent successfully.';
    
    $ch = curl_init('https://textbelt.com/text');
$data = array(
  'phone' => $number,
  'message' => "Hello! A movie on your MovieCritics watchlist has been released: $title!",
  'key' => '803957008c3f15b40489ea9fecd9453bc602cd9eyxyXSF4T14JXVCCekQDUAwCwB',
  );

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
echo " [x] Message sent: ", $response, "\n";
curl_close($ch);

} catch (Exception $e) {
    echo "Email could not be sent.";
}

//$number = "+19733934674";


}
?> 
