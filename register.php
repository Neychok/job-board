<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php'; include "classes/Users.php";

	$err = array(
		'first_name_err'    => "",
		'last_name_err'     => "",
		'password_err'      => "",
		'email_err' 	    => "",
		'repeat_err'	    => "",
		'phone_err' 	    => "",
		'site_err' 		    => "",
		'company_image_err' => ""
	);
	if(!empty($_POST)){
		$user = new User($_POST, $conn);
		if(isset($user->err)){
			$err = $user->err;
		}
		$is_clear = $user->is_clear;
		if($is_clear){
			
			if(!empty($_FILES["company_image"]["name"])){
				$user->insert($conn, $_FILES);
			}else{
				$user->insert($conn, "");
			}
		}
		
		
	}
?>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">Register</h2>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
								<div class="flex-container justified-horizontally">
									<div class="primary-container">
										<h4 class="form-title">About me</h4>
										<div class="form-field-wrapper">
											<input type="text" name="first_name" id="first_name" placeholder="First Name*"/>
											<span style="color: red" class="error">  <?php echo $err["first_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="last_name" id="Last_name" placeholder="Last Name*"/>
											<span style="color: red" class="error">  <?php echo $err["last_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="email" id="email" placeholder="Email*"/>
											<span style="color: red" class="error">  <?php echo $err["email_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="password" name="password" id="password" placeholder="Password*"/>
											<span style="color: red" class="error">  <?php echo $err["password_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="password" name="repeat" id="repeat" placeholder="Repeat Password*"/>
											<span style="color: red" class="error">  <?php echo $err["repeat_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="phone" id="phone" placeholder="Phone Number"/>
											<span style="color: red" class="error">  <?php echo $err["phone_err"];?> </span>
										</div>
									</div>
									<div class="secondary-container">
										<h4 class="form-title">My Company</h4>
										<div class="form-field-wrapper">
											<input type="text" name="companyName" id="companyName" placeholder="Company Name"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="companySite" id="companySite" placeholder="Company Site"/>
											<span style="color: red" class="error">  <?php echo $err["site_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<textarea name="description" id="description" placeholder="Description"></textarea>
										</div>
										<div class="form-field-wrapper width-large">
											<input type="file" name="company_image" id="company_image" placeholder="Image"/>
										</div>
									</div>		
								</div>
								<button class="button">
									Register
								</button>
							</form>
						</div>
					</div>
				</div>
			</section>	
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>