<!DOCTYPE html>
<html lang="en">

<?php
include 'header.php';

if(!empty($_GET['application_id'])){
	$stmt = $conn->prepare("SELECT * FROM applications LEFT JOIN users ON applications.user_id = users.id LEFT JOIN jobs on applications.job_id = jobs.id where applications.id = ?");
	$stmt->bind_param("s", $_GET['application_id']);
	$stmt->execute();
	$request_application = $stmt->get_result();
	$row = mysqli_fetch_array($request_application, MYSQLI_BOTH);
}else{
	header("Location: dashboard.php");
}
?>

<body>
	<div class="site-wrapper">
		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title"><?php echo "" . $row["title"] . " - " . $row["first_name"] . " " . $row["last_name"] . ""; ?></h2>
							</div>
							<form action="/uploads/cv/<?php echo($row['cv']) ?>">
								<div class="flex-container justified-horizontally flex-wrap">
									<div class="form-field-wrapper width-medium">
										<input type="text" placeholder="<?php echo $row["email"]; ?>" readonly />
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" placeholder="<?php echo $row["phone_number"]; ?>" readonly />
									</div>			
									<div class="form-field-wrapper width-large">
										<textarea placeholder="<?php echo $row["custom_message"]; ?>" readonly ></textarea>
									</div>
								</div>	
								
								<button type="submit" class="button">
									Download CV
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