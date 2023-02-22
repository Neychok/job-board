<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php';?>

<?php
$data = array();
$categories = array();
$err = array();

function print_error($error){
	echo $error;
}

if(!empty($_POST["create_done"])){
	if(empty($_POST["title"])){
		$err["job_title_err"] = "Job title is required.";
	} else {
		$data["job_title"] = validate($_POST["title"]);
	}

	if(!empty($_POST["location"])){
		$data["location"] = validate($_POST["location"]);
	}

	if(!empty($_POST["salary"])){
		$data["salary"] = intval(validate($_POST["salary"]));
		if(!is_int($data["salary"])){
			$err["salary_err"] = "Salary needs to be numeric.";
		}
	}

	if(empty($_POST["description"])){
		$err["description_err"] = "Job description is required.";
	} else {
		$data["description"] = validate($_POST["description"]);
	}

	if(!empty($_POST['categories'])){
		foreach($_POST['categories'] as $selected) {
			array_push($categories, $selected);
		}
	}

	if(empty($err)){
		$stmt = $conn->prepare("INSERT INTO 
		jobs(user_id, title, status, description, salary, date_posted, location) 
		VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), ?)");
		$status = 0;
		$stmt->bind_param("ssssss", $_SESSION['id'], $data['job_title'], 
						  $status, $data['description'], $data['salary'], $data["location"]);

		if ($stmt->execute() === FALSE) {
			echo "Error: " . $stmt->error;
		} else {
			$last_id = mysqli_insert_id($conn);
		}

		foreach($categories as $c) {
			$stmt = $conn->prepare("INSERT INTO jobs_categories(job_id, category_id) VALUES(?, ?)");
			$stmt->bind_param("ss", $last_id, $c);
			if ($stmt->execute() === FALSE) {
				echo "Error: " . $stmt->error;
			} else {
				header("Location: dashboard.php");
				die();
			}
		}
	}
} 
if(!empty($_POST["edit_done"])) {

		$edit_data           = array();
		$escaped_title       = "";
		$escaped_description = "";
		$escaped_location    = "";

		if(!empty($_POST['title'])) $edit_data['new_title']			    = validate($_POST['title']);
		if(!empty($_POST['location'])) $edit_data['new_location']	    = validate($_POST['location']);
		if(!empty($_POST['salary'])) $edit_data['new_salary'] 			= validate($_POST['salary']);
		if(!empty($_POST['description'])) $edit_data['new_description'] = validate($_POST['description']);

		$stmt = $conn->prepare("UPDATE jobs SET title	    = ?,
												location 	= ?, 
												salary 		= ?, 
												description = ?,
												status 		= 0 
											WHERE id		= ?");
							$stmt->bind_param("sssss",  $edit_data['new_title'],
														$edit_data['new_location'],
														$edit_data['new_salary'],
														$edit_data['new_description'],
														$_GET["edit_job"]);
		if ($stmt->execute() === FALSE) {
			echo "Error: " . $stmt->error;
		} else {
			header("Location: single.php?job_id=".$_GET['edit_job']."");
			die();
		}
}
if(!empty($_GET['edit_job'])){

	$stmt = $conn->prepare("SELECT * FROM jobs Where id = ?");
							$stmt->bind_param("s", $_GET['edit_job']);
							$stmt->execute();
							$select = $stmt->get_result();
							$row = $select->fetch_assoc();
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
								<h2 class="heading-title">
								<?php if(empty($_GET['edit_job'])){ ?>
									New job
								<?php } else { ?>
									Edit job
								<?php } ?>
								</h2>
							</div>
							<form method="post" action="">
								<div class="flex-container flex-wrap">
									<div class="form-field-wrapper width-large">
										<input type="text" name="title" placeholder="Job title*" value="<?php if(!empty($row['title'])){ echo $row['title']; } ?>"/>
										<span class="error">  <?php 
										if(!empty($err["job_title_err"]))
											(print_error($err["job_title_err"]))
											?> </span>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="text" name="location" placeholder="Location" value="<?php if(!empty($_GET['edit_job'])){ echo $row['location']; } ?>"/>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="number" name="salary" placeholder="Salary" value="<?php if(!empty($_GET['edit_job'])){ echo $row['salary']; } ?>"/>
										<span class="error">  <?php if(!empty($err["salary_err"]))
											(print_error($err["salary_err"]))?> </span>
									</div>
									<div class="form-field-wrapper width-large">
										<textarea name="description" placeholder="Description*"><?php if(!empty($_GET['edit_job'])){ echo $row['description']; } ?></textarea>
										<span class="error">  <?php if(!empty($err["description_err"]))
											(print_error($err["description_err"]))?> </span>
									</div>
									<?php if(empty($_GET['edit_job'])){ ?>
									<select multiple="multiple" class="form-field-wrapper width-large select" name="categories[]" multiple id="categories">
										<option style="text-align:center" disabled>
											Please choose one or more categories:
										</option>
											<?php 
											$cat_request = $conn->query("SELECT * FROM categories ORDER BY title ASC");
											if(mysqli_num_rows($cat_request) > 0) {
												while($row = mysqli_fetch_array($cat_request, MYSQLI_BOTH)){
											?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
											<?php }} ?>
									</select>
									<?php } ?>
								</div>
								<?php if(empty($_GET['edit_job'])){ ?>
								<button name="create_done" type="submit" class="button" value="create_done">
										Create
									<?php } else { ?>
								<div style="display: inline-flex;">
									<button name="edit_done" type="submit" class="button" value="edit_done">
											Submit
									</button>
								</div>
									<?php } ?>
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