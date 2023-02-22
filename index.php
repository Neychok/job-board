<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<body>

	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-preview">
				<div class="row">
					<form method = "get">
						<?php
						if(isset($_GET['filter'])){
						
							foreach($_GET['filter'] as $filter){
						?>
								<input type="hidden" name='filter[]' value='<?php echo($filter) ;?>'>
							
						<?php
							}
						}
						?> 	
							<ul class="tags-list">
							<?php 
							$request_category_homepage = $conn->query("SELECT title, id 
																			FROM categories 
																			ORDER BY title ASC");
							
							$url = $_SERVER['REQUEST_URI'];
							if(!strpos($url, "?")){
								$url = $url."?";
							}

							while($row = mysqli_fetch_array($request_category_homepage, MYSQLI_BOTH)){
								$style = "";
								if(isset($_GET['filter'])){
									if(in_array($row['id'], $_GET['filter'])){
										$style = 'style="background-color: #a1a9b5; pointer-events: none; cursor: default;"';
									}
									
								}
								
							?>
									<li class="list-item">
										<a <?php echo $style;?> href="<?php echo urldecode($url."&filter[]=".$row['id']);?>"  class="list-item-link"><?php echo $row['title'];?></a>
									</li>
							<?php 
							} 
							?>
							
							</ul>
						
							<div style="justify-content: space-between;" class="flex-container centered-vertically">
							<div class="flex-container centered-vertically">	
							<div class="search-form-wrapper">
									<div class="search-form-field" method = "get">
										<input class="search-form-input" type="text" placeholder="Search..." value='<?php if (isset($_GET['search'])) echo $_GET['search'];?>' name="search">
									</div> 
								</div>
								<?php
								if (!empty($_GET['drop_down_menu'])) {
									$drop_down_val = $_GET['drop_down_menu'];
								} else {
									$drop_down_val = 1;
								}
								?>
								
									<div class="filter-wrapper">
										<div class="filter-field-wrapper">
											<select name='drop_down_menu'>
												<option value="1" <?php if ($drop_down_val == 1) echo 'selected="selected"'; ?>>By Date</option>;
												<option value="2" <?php if ($drop_down_val == 2) echo 'selected="selected"'; ?>>Alphabetically</option>;
											</select>
										</div>
									</div>
									<button class="button" style="margin-left:10px;margin-bottom:15px;" type="submit" name="submit"> Search </button>
								</div>
								<div>
									<?php
										if(!empty($_GET['filter']) || !empty($_GET['search']) || !empty($_GET['drop_down_menu'])){
									?>
											<a href="<?php echo  $_SERVER["PHP_SELF"];?>" 
											class="button" style="background-color: red; margin-bottom:10px;"><b>Clear All</b></a>
									<?php
										}
									?>
									
								</div>
								</div>
					</form>
					<ul class="jobs-listing">
					<?php
					$order_list = "date DESC";
					if ( isset( $_GET['drop_down_menu' ] ) && $_GET['drop_down_menu'] == 2 ) {
						$order_list = "title ASC";
					}

					$search_key_word = "";
					if ( ! empty( $_GET['search'] ) ) {
						$search_key_word = "AND jobs.title LIKE concat('%', ?, '%')";
						$request_data[] = $_GET['search'];
					}

					$filter_request = array(
						'join' => "",
						'where' => ""
					);
					if ( ! empty($_GET['filter'] ) ) {
						$filter_request = array(
							'join' => " JOIN jobs_categories ON jobs.id=jobs_categories.job_id ",
							'where' => " AND jobs_categories.category_id IN ("
						);
						for($i = 0; $i < count($_GET['filter']); $i++){
							$filter_request['where'] = $filter_request['where'] . "?";
							if($i != count($_GET['filter']) - 1){
								$filter_request['where'] .= ",";
							}
							$request_data[] = $_GET['filter'][$i];
						}
						$filter_request["where"] = $filter_request["where"] . ")";
					}
					$sql_request = "SELECT DISTINCT jobs.id, jobs.title, jobs.location, jobs.status,
									DATEDIFF(CURDATE(), jobs.date_posted) AS 'date', 
									users.company_name, users.company_image, users.phone_number
									FROM jobs
									JOIN users ON users.id = jobs.user_id"
									. $filter_request['join'] 
									. " WHERE jobs.status = 1 " 
									. $search_key_word
									. $filter_request['where']
									. " ORDER BY " . $order_list;
					$stmp = $conn->prepare($sql_request);
					if ( isset( $request_data ) ) {
						$stmp->bind_param(str_repeat('s', count($request_data)), ...$request_data); 
					}
					$stmp->execute();
					$result = $stmp->get_result();
					$page_first_result = ($page-1) * RES_LIMIT;
					$num_rows = mysqli_num_rows ($result);
					$page_total = ceil($num_rows / RES_LIMIT);
					$request_data[] = $page_first_result;
					$request_data[] = RES_LIMIT;
					$stmp = $conn->prepare($sql_request . " LIMIT ? , ?");
					if ( isset( $request_data ) ) {
						$stmp->bind_param(str_repeat('s', count($request_data)), ...$request_data); 
					}
					$stmp->execute();
					$request_info = $stmp->get_result();
					?> <ul class="jobs-listing"> <?php
					if(mysqli_num_rows($request_info)){ ?>
						<p style="text-align:right; font-size:18px; margin-top:-1px;"><?php echo $num_rows; ?> jobs found.</p>
						<?php while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) {
						$company_image_path = IMAGE_PATH.$row["company_image"];?>
						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title"><a href="single.php?job_id=<?php echo $row['id']; ?>"><?php echo $row["title"];?></a></h2>
								<div class="job-meta">
									<a class="meta-company" href="#"><?php echo $row["company_name"];?></a>
									<span class="meta-date">Posted <?php echo time_diff_mesage($row["date"]);?></span>
								</div>
								<div class="job-details">
									<span class="job-location"><?php echo $row["location"];?></span>
									<span class="job-type"><b><?php echo $row["phone_number"];?></b></span>
								</div>
							</div>
							<div class="job-logo">
								<div class="job-logo-box">
									<img src=<?php echo $company_image_path;?> alt="">
								</div>
							</div>
						</li>
					<?php  
					}} else{ 
						?>  
						<p style="text-align:center; font-size:25px;">No jobs found.</p>
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