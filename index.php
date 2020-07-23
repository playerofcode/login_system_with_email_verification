<?php 
date_default_timezone_set('Asia/Kolkata');
if(isset($_POST['submit']))
{
 //getting value from form
	$name=$_POST['name'];
	$email=$_POST['email'];
	$mobno=$_POST['mobno'];
	$password=$_POST['password'];
	$token=date('dmyhis');//create unique code
	//connection with database
	$con=mysqli_connect('localhost','root','','php_tutorial_2k20');
	$query=mysqli_query($con,"select * from users where email='$email'");
	$count=mysqli_num_rows($query);
	if($count>0)
	{
		$msg="Email already Exist. Try another Email id. or <a href='login.php'>Click Here</a> to login";
	}
	else
	{
		//new email
	$query="insert into users(name,email,mobno,password,token) values ('$name','$email','$mobno','$password','$token')";
	$fire=mysqli_query($con,$query);
	if($fire)
	{
		//send email here
		require 'phpmailer/PHPMailerAutoload.php';
		$mail=new PHPMailer;
		$mail->Host='smtp.gmail.com';
		$mail->Port=587;
		$mail->isSMTP();
		$mail->SMTPAuth=true;
		$mail->SMTPSecure='tls';
		$mail->Username='youremail';//sender
		$mail->Password='your password';//password here
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
			$msg='You are registered successfully. Please verify your email.<br><a href="verify.php">Verify Now</a>';
		}
		
	}
	else
	{
		$msg="Something went wrong";
	}
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
							Registration Form
						</div>
						<div class="card-body">
							<form action="" method="post">
								<div class="form-group">
									<input type="text" name="name" class="form-control" placeholder="Enter Your Name">
								</div>
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="Enter Your Email">
								</div>
								<div class="form-group">
									<input type="text" name="mobno" class="form-control" placeholder="Enter Your Mobile Number">
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Create Your Password">
								</div>
								<div class="form-group">
									<input type="reset" class="btn btn-info">
									<input name="submit" type="submit" class="btn btn-primary">
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

