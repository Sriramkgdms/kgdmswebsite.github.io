<?php

require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

$mail = new PHPMailer();
$autoresponder = new PHPMailer();

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'sg2plcpnl0249.prod.sin2.secureserver.net';                  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@vfixindia.com';    // SMTP username
$mail->Password = 'Reset@123';                         // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to


if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['reservation_email'] != '' AND $_POST['reservation_phone'] != '' AND $_POST['reservation_brand'] != '') {
        
        $name = $_POST['reservation_name'];
        $email = $_POST['reservation_email'];
        $phone = $_POST['reservation_phone'];
        $mobile_brand = $_POST['reservation_brand'];
        $mobile_name = $_POST['reservation_model'];
		$mobile_colour = $_POST['reservation_colour'];
		$location_select = $_POST['location_select'];
		
      
      
       
	    if (isset($_POST['extra_services']) && !empty($_POST['extra_services']))      
			{
              foreach($_POST['extra_services'] as $selected )
			  {
             $problem.= $selected."\r\n";
              }
            }
		  
		 
       
		$subject = isset($subject) ? $subject : 'New Message | Mobile Problem Request';

		$botcheck = $_POST['contact-form-botcheck'];

        $toemail = 'info@vfixindia.com'; // Your Email Address
        $toname = 'Mobile Problem Request';                // Receiver Name

		if( $botcheck == '' ) {

			$mail->SetFrom( $email , $name );
			$mail->AddReplyTo( $email , $name );
			$mail->AddAddress( $toemail , $toname );
			$mail->Subject = $subject;
			$mail->AddCC('kranthi.talloju@gmail.com', 'Person One');
			
			
			$autoresponder->SetFrom( $toemail , $toname );
			$autoresponder->AddReplyTo( $toemail , $toname );
			$autoresponder->AddAddress( $email , $name );
			$autoresponder->Subject = 'We\'ve received your Email';

			$ar_body = "Thank you for contacting us. We will reply within 24 hours.<br><br>Regards,<br>Gadgetv fix.";


			$name = isset($name) ? "Name: $name<br><br>" : '';
            $mobile_brand = isset($mobile_brand) ? "Mobile Brand: $mobile_brand<br><br>" : '';
            $mobile_name = isset($mobile_name) ? "Mobile Model: $mobile_name<br><br>" : '';
			$mobile_colour = isset($mobile_colour) ? "Mobile Color: $mobile_colour<br><br>" : '';
	    
			$location_select = isset($location_select) ? "Location: $location_select<br><br>" : '';
			$problem = isset($problem) ? "Mobile Repair: $problem<br><br>" : '';
			
           
            $token = substr(md5(uniqid(rand(),'')),0,10); 
           
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Phone: $phone<br><br>" : '';
            
			$referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

			$body = "$name $email $phone  $mobile_brand  $mobile_name $mobile_colour   $problem  $location_select   Token :$token  $referrer";

			$ar_body = "Thank you for contacting us. Appointment for mobile repair has been confirmed with Referance id $token. For assistance call 9848 66 88 33.<br><br>Regards,<br>Gadgetv Fix.";

			$autoresponder->MsgHTML( $ar_body );
			$mail->MsgHTML( $body );
			$sendEmail = $mail->Send();

			  if( $sendEmail == true ):
                 echo '<script type="text/javascript">alert("Thank you for contacting us. We will be in touch with you very soon.");window.location.href = "http://vfixindia.com/";</script>';
	
            else:
                $message = 'Email <strong>could not</strong> be sent due to some Unexpected Error. Please Try Again later.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
                $status = "false";
            endif;
		} else {
			echo 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
		}
	} else {
		echo 'Please <strong>Fill up</strong> all the Fields and Try Again.';
	}
} else {
	echo 'An <strong>unexpected error</strong> occured. Please Try Again later.';
}

?>