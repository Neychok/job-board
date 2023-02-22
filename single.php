<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';

$job_id = $_GET['job_id'];

if ($job_id != null){
	$stmt = $conn->prepare("SELECT *, DATEDIFF(CURDATE(), jobs.date_posted) AS 'date' 
							FROM jobs 
							LEFT JOIN users ON jobs.user_id=users.id 
							WHERE jobs.id = ?");
	$stmt->bind_param("s", $_GET['job_id']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$job_exist = True;
	if(empty($row)){
		$job_exist = False;
	}
	$stmt = $conn->prepare("SELECT  categories.title 'category_title'
							FROM jobs 
							LEFT JOIN jobs_categories ON jobs_categories.job_id = jobs.id
							LEFT JOIN categories ON categories.id = jobs_categories.category_id
							WHERE jobs.id = ?");
	$stmt->bind_param("s", $_GET['job_id']);
	$stmt->execute();
	$result_category = $stmt->get_result();
	$row_category = mysqli_fetch_all($result_category,MYSQLI_ASSOC);

	$stmt = $conn->prepare("SELECT *, DATEDIFF(CURDATE(), jobs.date_posted) AS 'date' 
							FROM jobs_categories 
							LEFT JOIN jobs ON jobs.id = jobs_categories.job_id 
							LEFT JOIN users ON jobs.user_id=users.id
							WHERE  job_id != ? AND category_id 
							IN (SELECT subquery.category_id FROM jobs_categories subquery WHERE job_id = ? )
							ORDER BY rand() 
							LIMIT 0, 3");
	$stmt->bind_param("ss", $job_id, $job_id);
	$stmt->execute();
	$results_related_jobs = $stmt->get_result();
	$related_jobs = mysqli_fetch_all($results_related_jobs,MYSQLI_ASSOC);
}
?>

<body>
	<div class="site-wrapper">
		<?php if($job_exist == True){ 
			$company_image_path = IMAGE_PATH.$row["company_image"];?>
			<main class="site-main">
				<section class="section-fullwidth">
					<div class="row">
						<div class="job-single">
							<div class="job-main">
								<div class="job-card">
									<div class="job-primary">
										<header class="job-header"> 
													<h2 class="job-title"><?php echo $row['title'] ?></h2>
													<div class="job-meta">
														<?php echo $row["company_name"]; ?>
														<span class="meta-date">Posted <?php echo time_diff_mesage($row['date']); ?></span>
													</div>
													<ul style="margin-top:15px;"class="tags-list">
														<?php 
														foreach($row_category as $diff_categories){ ?>
															<a style="margin-right:10px;" class="list-item-link"><?php echo $diff_categories['category_title']; ?></a>
														<?php } ?>
														</ul>
													<div class="job-details">
														<span class="job-location"><?php echo $row['location'] ?></span>
														<span class="job-type"><b> <?php echo $row['phone_number']; ?></b></span>
														<span class="job-price"><?php echo $row['salary'] ?> Lv.</span>
													</div>
										</header>
												<div class="job-body">
													<P><?php echo nl2br($row['description']);?> </P>
												</div>
									</div>
								</div>
							</div>
							<aside class="job-secondary">
								<div class="job-logo">
									<div class="job-logo-box">
										<img src="<?php echo $company_image_path ?>" alt="">
									</div>
								</div>
								<?php if(!empty($_SESSION['id'])){
										if($_SESSION['id'] != $row['user_id']) {?>
								<div>
									<a href="apply-submission.php?job_id=<?php echo($_GET['job_id']) ?>" class="button button">Apply now</a>
								</div>
								<?php } else { ?>
									<a href="actions-job.php?edit_job=<?php echo($_GET['job_id']) ?>" class="button button">Edit now</a>
								<?php } }?>
								<div>
									<a href="<?php echo $row['company_site']?>"> <?php echo $row['company_name']?></a>
								</div>
							</aside>
						</div>
					</div>
				</section>
			</main>
			<section class="section-fullwidth">
					<div class="row">
						<h2 class="section-heading">Other related jobs:</h2>
							<?php foreach($related_jobs as $jobs){ 
								$others_image_path = IMAGE_PATH.$jobs["company_image"]; ?>
									<ul class="jobs-listing">
										<li class="job-card">
											<div class="job-primary">
												<h2 class="job-title"><a href="single.php?job_id=<?php echo $jobs['job_id']; ?>"><?php echo $jobs['title']?></a></h2>
												<div class="job-meta">
													<?php echo $jobs["company_name"]; ?></a>
													<span class="meta-date">Posted <?php echo time_diff_mesage($jobs['date']); ?></span>
												</div>
												<div class="job-details">
													<span class="job-location"><?php echo $jobs['location'] ?></span>
													<span class="job-type">Contract staff</span>
													<span class="job-price"><?php echo $jobs['salary'] ?> Lv.</span>
												</div>
											</div>
											<div class="job-logo">
												<div class="job-logo-box">
													<img src="<?php echo $others_image_path ?>" alt="">
												</div>
											</div>
										</li>
									</ul>
							<?php } ?>
					</div>
				</section>
			<?php } ?>
			<?php if($job_exist == False){ ?>
			<h2 class="section-heading">No Jobs Found</h2>
			<?php } ?>
	</div>
	<?php include 'footer.php';?>
</body>
</html> 