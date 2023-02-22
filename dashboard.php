<!DOCTYPE html>
<html lang="en">

<script type="text/javascript" src="engine1/jquery.js"></script> 

<?php 
include 'header.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
	$order = 'date_posted DESC';
	if(isset($_GET['drop_down_menu']) && $_GET["drop_down_menu"] == 2){
		$order = 'title ASC';
	}

	$search = '';
	if(!empty($_GET['search'])){
		$search = validate($_GET['search']);
	}

	if (!empty($_GET['drop_down_menu'])) {
		$menu_value = validate($_GET['drop_down_menu']);
	} else {
		$menu_value = 1;
	}

	$stmt = $conn->prepare("SELECT is_admin FROM users WHERE users.id = ?");
	$stmt->bind_param('s', $_SESSION['id']);
	$stmt->execute();
	$is_admin_request = $stmt->get_result();
	$admin_row = mysqli_fetch_array($is_admin_request);
	$request = "";

	if(!$admin_row['is_admin']){
		$request = "SELECT *, jobs.id AS 'job_id', DATEDIFF(CURDATE(), jobs.date_posted) AS 'date' 
					FROM jobs 
					LEFT JOIN users ON jobs.user_id = users.id
					WHERE jobs.user_id = ?
					HAVING jobs.title LIKE concat('%', ?, '%')
					ORDER BY ". $order."";
		$stmt = $conn->prepare($request);
		$stmt->bind_param('ss', $_SESSION['id'], $search);
	} else {
		$request = "SELECT *, jobs.id AS 'job_id', DATEDIFF(CURDATE(), jobs.date_posted) AS 'date' 
					FROM jobs 
					LEFT JOIN users ON jobs.user_id = users.id
					HAVING jobs.title LIKE concat('%', ?, '%')
					ORDER BY ".$order."";
		$stmt = $conn->prepare($request);
		$stmt->bind_param('s', $search);
	}
	$stmt->execute();
	$result = $stmt->get_result();
	$num_rows = mysqli_num_rows ($result);
	$page_total = ceil($num_rows / RES_LIMIT);
	$stmt->prepare($request." LIMIT ?, ?");
	$limit = RES_LIMIT;
	if(!$admin_row['is_admin']){
		$stmt->bind_param('ssss',  $_SESSION['id'], $search, $page_first_result, $limit);
	} else {
		$stmt->bind_param('sss', $search, $page_first_result, $limit);
	}
	$stmt->execute();
	$request_info = $stmt->get_result();
}

?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-dashboard">
				<div class="row">
					<div class="jobs-dashboard-header flex-container centered-vertically justified-horizontally">
						<div class="primary-container">							
							<ul class="tabs-menu">
								<li class="menu-item current-menu-item">
									<a href="dashboard.php">Jobs</a>					
								</li>
								<li class="menu-item">
									<a href="category-dashboard.php">Categories</a>
								</li>
							</ul>
						</div>
						<div  style="display:inline-flex;" class="secondary-container">
							<div class="flex-container centered-vertically">
								<form>
									<div style="display:inline-flex;" class="search-form-wrapper">
										<div class="search-form-field"> 
											<input class="search-form-input" type="text" value="<?php if (isset($_GET['search'])) echo $_GET['search'];?>" placeholder="Search…" name="search" > 
										</div> 
									</div>
									<div style="display:inline-flex;" class="filter-wrapper">
										<div class="filter-field-wrapper">
											<select name="drop_down_menu">
												<option value="1" <?php if ($menu_value == 1) echo 'selected="selected"'; ?>>Date</option>
												<option value="2" <?php if ($menu_value == 2) echo 'selected="selected"'; ?>>Alphabetically</option>
											</select>
										</div>
									</div>
									<div style="display: inline-flex; margin-left: -10px;" class="button-wrapper">
										<form method="post">
											<button class="button" type="submit">Submit</button>
										</form>
									</div>
								</form>
							</div>
						</div>
					</div>
					<ul class="jobs-listing"> 
					<?php
					while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) { ?>
						<li id="card" class="job-card">
							<div class="job-primary">
								<h2 class="job-title"><a href="single.php?job_id=<?php echo $row['job_id']; ?>"><?php echo $row["title"]; ?></a></h2>
								<div class="job-meta">
									<a class="meta-company" href="#"><?php echo $row["company_name"]; ?></a>
									<span class="meta-date">Posted <?php echo time_diff_mesage($row["date"]); ?></span>
								</div>
								<div class="job-details">
									<span class="job-location"><?php echo $row["location"]; ?></span>
									<span class="job-type"><b><?php echo $row["phone_number"]; ?></b></span>
								</div>
							</div>
							<div class="job-secondary">
								<div class="job-actions">
								<?php if($admin_row['is_admin'] == 1){?>
									<a <?php if($row['status'] == 1){ ?> style="display:none" <?php } ?> data-id="<?php echo $row['job_id'];?>" class="approve-button" href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $menu_value; ?>&job_id=<?php echo $row['job_id'];?>"> 
									Approve </a>

									<a <?php if($row['status'] == 0){ ?> style="display:none" <?php } ?> data-id="<?php echo $row['job_id'];?>" class="reject-button" href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $menu_value; ?>&job_id=<?php echo $row['job_id'];?>">
									Reject</a>
								<?php } ?>

									<a data-id="<?php echo $row['job_id'];?>" class="delete-button" href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $menu_value; ?>&job_id=<?php echo $row['job_id'];?>" class="delete-button"> 
									Delete </a>
								</div>
								<div class="job-edit">
									<a href="submissions.php?job_id=<?php echo $row['job_id']; ?>">View Submissions</a>
									<a href="actions-job.php?edit_job=<?php echo $row['job_id']?>">Edit</a>
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
						</ul>		
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>