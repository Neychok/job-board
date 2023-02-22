<!DOCTYPE html>
<html lang="en">
<body>
	<?php 
		include 'header.php';	
			$user_id = $_SESSION['id'];
			$stmt = $conn->prepare("SELECT * FROM users WHERE ? = users.id");
			$stmt->bind_param("s", $user_id);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt1 = $conn->prepare("SELECT company_name from users left join jobs on jobs.user_id = users.id where jobs.id = ?");
			$stmt1->bind_param("s", $_GET['job_id']);
			$stmt1->execute();
			$result1 = $stmt1->get_result();
			if ($result1->num_rows > 0) {
				$row1 = $result1->fetch_assoc();
				if(empty($row1)){
					echo "0 results";
				}
			}
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				if(empty($row)){
					echo "0 results";
				}
			}
		
		if(!empty($_POST)){
			if(!empty($_FILES["cv"])){
				$pname = $_FILES["cv"]["name"]; 
				$tname = $_FILES["cv"]["tmp_name"];
				
				$name = pathinfo($_FILES['cv']['name'], PATHINFO_FILENAME);
				$extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
				
				$increment = 0; 
				$pname = $name . '.' . $extension;
			}else{
				echo "image empty";
			}
			
			while(is_file('uploads/cv'.'/'.$pname)) {
				$increment++;
				$pname = $name . $increment . '.' . $extension;
			}
	
	
	
			$target_file = 'uploads/cv'.'/'.$pname;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			if($imageFileType != "pdf" && $imageFileType != "docx") {
				echo "wrong format";
				$cv_err = "Wrong file format!";
				$uploadOk = 0;
			}
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			}else {
				if (move_uploaded_file($tname, $target_file) && empty($cv_err)) {
				$company_image = basename( $pname);
				} else {
					$cv_err = "Wrong file format!";
					echo "Sorry, there was an error uploading your file.";
				}
			}
			$job_id = validate($_POST['job_id']);
			$custom_message = validate($_POST['custom_message']);
			if(isset($company_image)){
				$stmt = $conn->prepare("INSERT into applications(user_id, job_id, custom_message, cv) 
										values (?, ?, ?, ?)");
				$stmt->bind_param("ssss", $user_id, $job_id, $custom_message, $company_image);
				$stmt->execute();

				$success = "Application submitted successfully!";
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
								<?php if ( isset( $success ) ) : ?>
									<div role="alert" style="color: green; margin-bottom:1rem;">
										<?php echo $success; ?>
									</div>
								<?php endif; ?>
								<h2 class="heading-title">Submit application to
									<?php echo($row1['company_name']); ?></h2>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?job_id=' . $_GET['job_id'] ?>" method="post" enctype="multipart/form-data">
								<div class="flex-container justified-horizontally flex-wrap">									
									<div class="form-field-wrapper width-medium">
										<input type="text" name="first_name" value="<?php echo($row['first_name']) ?>" placeholder="First Name*"/>
										<span class="error">  <?php //echo $err["first_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="last_name" value="<?php echo($row['last_name']) ?>" placeholder="Last Name*"/>
										<span class="error">  <?php //echo $err["last_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="email" value="<?php echo($row['email']) ?>" placeholder="Email*"/>
										<span class="error">  <?php //echo $err["email_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="phone_number" value="<?php echo($row['phone_number']) ?>" placeholder="Phone Number"/>
										<span class="error">  <?php //echo $err["phone_err"];?> </span> 
									</div>			
									<div class="form-field-wrapper width-large">
									<span class="error" >  <?php //echo $err["message_err"];?> </span>  
										<textarea placeholder="Custom message*" name="custom_message"></textarea>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="file" name="cv"/>
										<span class="error" >  <?php //echo $err["file_err"];?> </span> 
									</div>
									<div>
										<input type="hidden" name="job_id" value=<?php if(!empty($_GET["job_id"]))echo($_GET["job_id"]) ?> />
									</div>
								</div>	
								<button class="button">
									Submit
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