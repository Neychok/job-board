<?php
require_once( 'init.php' );
require_once( ROOT_DIR . '/template-parts/header.php' );

?>
<main class="site-main">
	<section class="section-fullwidth section-jobs-preview">
		<div class="row">	
			<ul class="tags-list">
				<li class="list-item">
					<a href="#" class="list-item-link">IT</a>
				</li>
				<li class="list-item">
					<a href="#" class="list-item-link">Manufactoring</a>
				</li>
				<li class="list-item">
					<a href="#" class="list-item-link">Commerce</a>
				</li>
				<li class="list-item">
					<a href="#" class="list-item-link">Architecture</a>
				</li>
				<li class="list-item">
					<a href="#" class="list-item-link">Marketing</a>
				</li>
			</ul>
			<div class="flex-container centered-vertically">
				<div class="search-form-wrapper">
					<div class="search-form-field"> 
						<input class="search-form-input" type="text" value="" placeholder="Search…" name="search" > 
					</div> 
				</div>
				<div class="filter-wrapper">
					<div class="filter-field-wrapper">
						<select>
							<option value="1">Date</option>
							<option value="2">Date</option>
							<option value="3">Date</option>
							<option value="4">Type</option>
						</select>
					</div>
				</div>
			</div>
			<ul class="jobs-listing">
				<li class="job-card">
					<div class="job-primary">
						<h2 class="job-title"><a href="#">Front End Developer</a></h2>
						<div class="job-meta">
							<a class="meta-company" href="#">Company Awesome Ltd.</a>
							<span class="meta-date">Posted 14 days ago</span>
						</div>
						<div class="job-details">
							<span class="job-location">The Hague (The Netherlands)</span>
							<span class="job-type">Contract staff</span>
						</div>
					</div>
					<div class="job-logo">
						<div class="job-logo-box">
							<img src="https://i.imgur.com/ZbILm3F.png" alt="">
						</div>
					</div>
				</li>

				<li class="job-card">
					<div class="job-primary">
						<h2 class="job-title"><a href="#">Front End Developer</a></h2>
						<div class="job-meta">
							<a class="meta-company" href="#">Company Awesome Ltd.</a>
							<span class="meta-date">Posted 14 days ago</span>
						</div>
						<div class="job-details">
							<span class="job-location">The Hague (The Netherlands)</span>
							<span class="job-type">Contract staff</span>
						</div>
					</div>
					<div class="job-logo">
						<div class="job-logo-box">
							<img src="https://i.imgur.com/ZbILm3F.png" alt="">
						</div>
					</div>
				</li>
				<li class="job-card">
					<div class="job-primary">
						<h2 class="job-title"><a href="#">Front End Developer</a></h2>
						<div class="job-meta">
							<a class="meta-company" href="#">Company Awesome Ltd.</a>
							<span class="meta-date">Posted 14 days ago</span>
						</div>
						<div class="job-details">
							<span class="job-location">The Hague (The Netherlands)</span>
							<span class="job-type">Contract staff</span>
						</div>
					</div>
					<div class="job-logo">
						<div class="job-logo-box">
							<img src="https://i.imgur.com/ZbILm3F.png" alt="">
						</div>
					</div>
				</li>
				<li class="job-card">
					<div class="job-primary">
						<h2 class="job-title"><a href="#">Front End Developer</a></h2>
						<div class="job-meta">
							<a class="meta-company" href="#">Company Awesome Ltd.</a>
							<span class="meta-date">Posted 14 days ago</span>
						</div>
						<div class="job-details">
							<span class="job-location">The Hague (The Netherlands)</span>
							<span class="job-type">Contract staff</span>
						</div>
					</div>
					<div class="job-logo">
						<div class="job-logo-box">
							<img src="https://i.imgur.com/ZbILm3F.png" alt="">
						</div>
					</div>
				</li>
				<li class="job-card">
					<div class="job-primary">
						<h2 class="job-title"><a href="#">Front End Developer</a></h2>
						<div class="job-meta">
							<a class="meta-company" href="#">Company Awesome Ltd.</a>
							<span class="meta-date">Posted 14 days ago</span>
						</div>
						<div class="job-details">
							<span class="job-location">The Hague (The Netherlands)</span>
							<span class="job-type">Contract staff</span>
						</div>
					</div>
					<div class="job-logo">
						<div class="job-logo-box">
							<img src="https://i.imgur.com/ZbILm3F.png" alt="">
						</div>
					</div>
				</li>
			</ul>
			<div class="jobs-pagination-wrapper">
				<div class="nav-links"> 
					<a class="page-numbers current">1</a> 
					<a class="page-numbers">2</a> 
					<a class="page-numbers">3</a> 
					<a class="page-numbers">4</a> 
					<a class="page-numbers">5</a> 
				</div>
			</div>
		</div>
	</section>	
</main>
<?php require_once( ROOT_DIR . '/template-parts/footer.php' ); ?>

