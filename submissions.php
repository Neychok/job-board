<!DOCTYPE html>
<html lang="en">

<?php 
include 'header.php'; 

$request_application = "SELECT applications.id as 'app_id', jobs.id, jobs.title, 
users.first_name, users.last_name, applications.user_id 
FROM applications 
LEFT JOIN jobs ON applications.job_id=jobs.id 
LEFT JOIN users ON applications.user_id=users.id
WHERE jobs.id=" . $_GET['job_id'] ."";

$page_first_result = ($page-1) * RES_LIMIT;
$num_rows = mysqli_num_rows ($conn->query($request_application));
$page_total = ceil($num_rows / RES_LIMIT);
$request_info = $conn->query($request_application." LIMIT " . $page_first_result . ','. RES_LIMIT);
?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">						
					<ul class="tabs-menu">
						<li class="menu-item current-menu-item">
							<a href="dashboard.php">Jobs</a>					
						</li>
						<li class="menu-item">
							<a href="category-dashboard.php">Categories</a>
						</li>
					</ul>
					<ul class="jobs-listing">
						<?php
						$title_check = 0;
						if(mysqli_num_rows($request_info) > 0){
							while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) {?>
								<div class="section-heading">
									<?php if(!$title_check){?>
										<h2 class="heading-title"><?php echo $row["title"];?> - Submissions - <?php echo mysqli_num_rows( $request_info); ?> Appliciants</h2>
									<?php $title_check=1; }?>	
								</div>
									<li class="job-card">
										<div class="job-primary">
											<h2 class="job-title"><?php echo "" . $row["first_name"] . " " . $row["last_name"] . "";?></h2>
										</div>
										<div class="job-secondary centered-content">
											<div class="job-actions">
												<a href="view-submission.php?application_id=<?php echo $row['app_id']; ?>" class="button button-inline">View</a>
												<a href="submissions.php?job_id=<?php echo $row['id']; ?>" class="button button-inline delete-submission-button" data-id="<?php echo $row['app_id'];?>">Delete</a>
											</div>
										</div>
									</li>
							<?php  
							}
							?> 
								<div class="jobs-pagination-wrapper">
									<div class="nav-links">
										<?php pagination($page, $page_total); ?>
									</div>
								</div>
							<?php	
							} else { 
								$request_job_title = $conn->query(
									"SELECT jobs.title FROM jobs WHERE jobs.id=" . $_GET['job_id'] ."");
								$job_row = mysqli_fetch_array($request_job_title, MYSQLI_BOTH) ?>
								<h2 class="heading-title"><?php echo $job_row['title'];?> - Submissions - 0 Appliciants</h2>
						<?php 
							} 
							?>
					</ul>
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>