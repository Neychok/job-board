<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<?php
	$category_name = "";
	$category_err  = "";
	$user_id 	   = $_SESSION['id'];
	$stmt 		   = $conn->prepare("SELECT is_admin FROM users WHERE ? = users.id");
	$stmt->bind_param("s", $user_id);
	$stmt->execute();
	$result 	   = $stmt->get_result();

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if(empty($row)){
			echo "0 results";
		}
	}
	$is_admin = $row['is_admin'];
	if($row['is_admin'] == 1){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(!empty($_POST["new_category"])){
				$category_name = validate($_POST["new_category"]);
				$stmt = $conn->prepare("INSERT INTO categories(title) VALUES(?)");
				$stmt->bind_param("s", $category_name);
				$stmt->execute();
			}
		}
	
		if($_SERVER["REQUEST_METHOD"] == "GET"){
			if(!empty($_GET['cat_id'])){
				$delete_category_id = validate($_GET['cat_id']);
				$stmt = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
				$stmt->bind_param("s", $delete_category_id);
				$stmt->execute();
			}
		}
	}
?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-dashboard">
				<div class="row">						
					<div class="jobs-dashboard-header">
						<div class="primary-container">							
							<ul class="tabs-menu">
								<li class="menu-item">
									<a href="dashboard.php">Jobs</a>					
								</li>
								<li class="menu-item current-menu-item">
									<a href="category-dashboard.php">Categories</a>
								</li>
							</ul>
						</div>
						<div class="secondary-container">
							<div class="form-box category-form">
								<form method="post" action="" >
									<div class="flex-container justified-vertically">	
										<?php if($row['is_admin'] == 1){?>								
										<div class="form-field-wrapper">
											<input type="text" name="new_category" placeholder="Enter Category Name..."/>
										</div>
											<button class="button" >Add New</button>
										<?php }; ?>
									</div>	
								</form>
							</div>
						</div>
					</div>

					<?php
					$request_category = "SELECT * FROM categories ORDER BY title ASC";
					$page_first_result = ($page-1) * RES_LIMIT;
					$num_rows = mysqli_num_rows ($conn->query($request_category));
					$page_total = ceil($num_rows / RES_LIMIT);
					$request_info = $conn->query($request_category." LIMIT " . $page_first_result . ','. RES_LIMIT);

					?> <ul class="jobs-listing"> <?php
					while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) { ?>
						<li class="job-card">
						<div class="job-primary">
							<h2 class="job-title"><?php echo $row["title"]?></h2>
						</div>
						<div class="job-secondary centered-content">
							<div class="job-actions">
								<?php if(isset($is_admin) && $is_admin){?>
								<a href="<?php echo $_SERVER["PHP_SELF"]?>?cat_id=<?php echo $row['id']; ?>" class="button button-inline">Delete</a>
								<?php }; ?>
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