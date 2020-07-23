<?php 
date_default_timezone_set('Asia/Kolkata');
if(isset($_POST['submit']))
{
$con=mysqli_connect('localhost','root','','php_tutorial_2k20');	
$email=$_POST['email'];
$query="select * from users where email='$email'";
$fire=mysqli_query($con,$query);
$count=mysqli_num_rows($fire);
if($count>0)
{
$token=date('dmyhis');//create unique code
mysqli_query($con,"update users set token='$token' where email='$email'");
//send email here
		require 'phpmailer/PHPMailerAutoload.php';
		$mail=new PHPMailer;
		$mail->Host='smtp.gmail.com';
		$mail->Port=587;
		$mail->isSMTP();
		$mail->SMTPAuth=true;
		$mail->SMTPSecure='tls';
		$mail->Username='youremail';//sender
		$mail->Password='emailpassword';//password here
		$mail->setFrom('youremail','Notification');
		$mail->addAddress($email);//receiver
		$mail->addReplyTo('noreply@playerofcode.com','noReply');
		$mail->isHTML(true);
		$mail->Subject='Be The Player Of Code';
		$mail->Body='<h1 style="background:navy;color:white;padding:10px;text-align:center;">Email Verifcation</h1><p>Your Email Verification Code is '.$token.'</p>';
		if(!$mail->send())
		{
			$msg=$mail->ErrorInfo;
		}
		else
		{
			$msg='Verification code sent successfully. Please verify your email.<br><a href="verify.php">Verify Now</a>';
		}
}
else
{
	$msg="Email account does not match.<br><a href='index.php'>Click Here</a> to Register";
}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Email Verification </title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="row mt-1">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<?php 
					//setting error message here
					if(isset($msg)): ?>
					<div class="alert alert-warning" role="alert">
						<strong>Alert!</strong> <?php echo $msg; ?>
					</div>
					 <?php endif; ?>
					
					<div class="card text-center">
						<div class="card-header text-white bg-primary">
							Re-send Code
						</div>
						<div class="card-body">
							<form action="" method="post">
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="Enter Your Email">
								</div>
								<div class="form-group">
									<input name="submit" type="submit" class="btn btn-danger" value="Resend Code">
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script></body>
</html>

