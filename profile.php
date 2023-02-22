<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php'; include 'classes/users.php';
	$stmt = $conn->prepare("SELECT * FROM users WHERE ? = users.id");
	$stmt->bind_param("s", $user_id);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if(empty($row)){
			echo "0 results";
		}
	}
	$change = false;
	$err = array(
		'first_name_err' 	=> "",
		'last_name_err'  	=> "",
		'password_err'   	=> "",
		'email_err' 	 	=> "",
		'repeat_err'	 	=> "",
		'phone_err'	   	    => "",
		'site_err'		 	=> "",
		'company_image_err' => ""
	);
	$user_data = array(
		'id'			=> $row["id"],
		'first_name' 	=> $row["first_name"],
		'last_name'  	=> $row["last_name"],
		'email'		 	=> $row["email"],
		'password'	 	=> $row["password"],
		'repeat'		=> $row["password"],
		'phone'	     	=> "",
		'company_name'  => "",
		'company_site'  => "",
		'description'   => "",
		'company_image' => "",
		'is_admin'		=> false
	);
	$changes = array(
		'first_name_change'   		 =>	array('first_name', false),
		'last_name_change'    		 =>	array('last_name', false),
		'email_change'	     		 =>	array('email', false),
		'phone_number_change'		 =>	array('phone_number', false),
		'company_name_change'		 =>	array('company_name', false),
		'company_site_change' 		 =>	array('company_site', false),
		'company_description_change' =>	array('company_description', false),
		'company_image_change' 		 =>	array('company_image', false)
	);
	if(isset($row["phone_number"]) && isset($_POST["phone_number"])){
		$user_data["phone"] = $row["phone_number"];
		if($user_data["phone"] != $_POST["phone_number"]){
			$change = true;
			$changes['phone_number_change'][1] = true;
		}
	}
	if(isset($row["company_name"]) && isset($_POST["company_name"])){
		$user_data["company_name"] = $row["company_name"];
		if($user_data["company_name"] != $_POST["company_name"]){
			$change = true;
			$changes['company_name_change'][1] = true;
		}
	}
	if(isset($row["company_site"]) && isset($_POST["company_site"])){
		$user_data["company_site"] = $row["company_site"];
		if($user_data["company_site"] != $_POST["company_site"]){
			$change = true;
			$changes['company_site_change'][1] = true;
		}
	}
	if(isset($row["company_description"]) && isset($_POST["company_description"])){
		$user_data["description"] = $row["company_description"];
		if($user_data["description"] != $_POST["company_description"]){
			$change = true;
			$changes['company_description_change'][1] = true;
		}
	}
	if(isset($_POST['password'])){
		if(isset($_POST["repeat"])){
			$change = true;
			$changes['password_change'][1] = true;
		}else{
			$err['repeat_err'] = 'enter new password!';
		}
	}
	if(isset($user_data["first_name"]) && isset($_POST["first_name"])){
		if(strcmp($user_data["first_name"], $_POST["first_name"]) !== 0){
			$user_data["first_name"] = $_POST["first_name"];
			$change = true;
			$changes['first_name_change'][1] = true;
		}
	}
	if(isset($user_data["last_name"]) && isset($_POST["last_name"])){
		if($user_data["last_name"] != $_POST["last_name"]){
			$change = true;
			$changes['last_name_change'][1] = true;
		}
	}
	if(isset($user_data["email"]) && isset($_POST["email"])){
		if($user_data["email"] != $_POST["email"]){
			$change = true;
			$changes['email_change'][1] = true;
		}
	}

	if(isset($row["company_image"]) && isset($_FILES["company_image"]["name"])){
		$user_data['company_image'] = $row["company_image"];
		if(strcmp($user_data["company_image"], $_FILES["company_image"]["name"]) != 0){
			$change = true;
			$changes['company_image_change'][1] = true;
		}
	}
	if($change == true){
		$changed = true;
		foreach($changes as $c){
			if($c[1]){
				if(isset($c[0])){
					if($c[0] == 'email'){
						if(filter_var($_POST[$c[0]], FILTER_VALIDATE_EMAIL) != true && !empty($_POST[$c[0]])){
							$err["email_err"] = "email is not valid!";
							$changed = false;
							continue;
						}else{
							$stmt = $conn->prepare("SELECT COUNT(*) as count FROM users Where ? = email");
							$stmt->bind_param("s", $_POST[$c[0]]);
							$stmt->execute();
							$select = $stmt->get_result();
							$result = $select->fetch_assoc();
							if($result['count'] == 0){
								mysqli_query($conn, "Update users set $c[0] = '{$_POST[$c[0]]}' where id = ''$user_id");
								continue;
							}else{
								$err['email_err'] = "email already exists!";
								$changed = false;
								continue;
							}
						}
					}
					if($c[0] == 'phone_number'){
						if(!preg_match('/^[0-9]{10}+$/', $_POST[$c[0]])){
							$err['phone_err'] = "phone number is not valid!";
							$changed = false;
							continue;
						}else{
							mysqli_query($conn, "Update users set $c[0] = {$_POST[$c[0]]} where id = $user_id");
							continue;
						}
					}
					if($c[0] == 'company_site'){
						if(!filter_var($_POST[$c[0]], FILTER_VALIDATE_URL) && !empty($_POST[$c[0]])){
							$err["site_err"] = "site url is not valid!";
							$changed = false;
							continue;
						}
						else{
							mysqli_query($conn, "Update users set $c[0] = '{$_POST[$c[0]]}' where id = $user_id");
							continue;
						}
					}
					if($c[0] == 'company_image'){
						if(!empty($_FILES["company_image"])){
							$pname = $_FILES["company_image"]["name"]; 
							$tname = $_FILES["company_image"]["tmp_name"];
							
							$name = pathinfo($_FILES['company_image']['name'], PATHINFO_FILENAME);
							$extension = pathinfo($_FILES['company_image']['name'], PATHINFO_EXTENSION);
							
							$increment = 0; 
							$pname = $name . '.' . $extension;
						}else{
							echo "image empty";
						}
						while(is_file('uploads/images'.'/'.$pname)) {
							$increment++;
							$pname = $name . $increment . '.' . $extension;
						}
				
				
				
						$target_file = 'uploads/images'.'/'.$pname;
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
						&& $imageFileType != "gif" && $imageFileType != "jiff") {
							$err["company_image_err"] = "Wrong file format!";
							echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
							$uploadOk = 0;
						}
						
						if ($uploadOk == 0) {
							echo "Sorry, your file was not uploaded.";
					
						} else {
							if (move_uploaded_file($tname, $target_file) && empty($err["company_image_err"])) {
								$company_image = basename( $pname);
								$stmt = $conn->prepare("UPDATE users SET company_image = ? WHERE id = ?");
								$stmt->bind_param("ss", $company_image, $user_id);
								$stmt->execute();
								header("Location: profile.php");
							}else {
								$err["company_image_err"] = "Wrong file format!";
								echo "Sorry, there was an error uploading your file.";
							}
						}
					}
					if($c[0] == 'password'){
						continue;
					}
				}
				if(isset($c[0]) && isset($_POST[$c[0]])){
					$stmt = $conn->prepare("Update users set $c[0] = ? where id = ?");
					$stmt->bind_param("ss", $_POST[$c[0]], $user_id);
					$stmt->execute();
				}
			}
		}
		if($changed){
			header("Location: profile.php");
		}
	}
	if(!empty($_POST["password"]) && isset($row["password"])){
		if(!empty($_POST["repeat"])){
			if(password_verify($_POST["password"], $row["password"])){	
				$user = new User($user_data, $conn);
				$err["repeat_err"] = $user->update_password($conn, $_POST["repeat"]);
			}else{
				$err["password_err"] = "passwords do not match!";
			}
		}else{
			$err["repeat_err"] = "enter new password!";
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
								<h2 class="heading-title">My Profile</h2>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
								<div class="flex-container justified-horizontally">
									<div class="primary-container">
										<h4 class="form-title">About me</h4>
										<div class="form-field-wrapper">
											<input type="text" name='first_name' id='first_name' value="<?php echo htmlspecialchars($row["first_name"]);?>" placeholder="First Name*"/>
											<span class="error">  <?php echo $err["first_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='last_name' id='last_name' value="<?php echo htmlspecialchars($row["last_name"]);?>" placeholder="Last Name*"/>
											<span class="error">  <?php echo $err["last_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='email' id='email' value="<?php echo htmlspecialchars($row["email"]);?>" placeholder="Email*"/>
											<span class="error">  <?php echo $err["email_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="password" name='password' id='password'  placeholder="Current Password"/>
											<span class="error">  <?php echo $err["password_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="password" name='repeat' id='repeat' placeholder="New Password"/>
											<span class="error">  <?php echo $err["repeat_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='phone_number' id='phone_number' value="<?php echo htmlspecialchars($row["phone_number"]);?>" placeholder="Phone Number"/>
											<span class="error">  <?php echo $err["phone_err"];?> </span>
										</div>
									</div>
									<div class="secondary-container">
										<h4 class="form-title">My Company</h4>
										<div class="form-field-wrapper">
											<input type="text" name='company_name' id='company_name' value="<?php echo htmlspecialchars($row["company_name"]);?>" placeholder="Company Name"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='company_site' id='company_site' value="<?php echo htmlspecialchars($row["company_site"]);?>" placeholder="Company Site"/>
											<span class="error">  <?php echo $err["site_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<textarea id="company_description" name="company_description" placeholder="Description"><?php echo htmlspecialchars($row["company_description"]);?></textarea>
										</div>
										<div class="form-field-wrapper width-large">
											<input type="file" name="company_image" id="company_image" placeholder="Image"/>
											<span class="error" >  <?php echo $err["company_image_err"];?> </span> 
										</div>
									</div>		
								</div>					
								<button class="button">
									Save
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