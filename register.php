<?php
require_once( 'init.php' );
require_once( ROOT_DIR . '/template-parts/header.php' );
?>
<main class="site-main">
	<section class="section-fullwidth">
		<div class="row">	
			<div class="flex-container centered-vertically centered-horizontally">
				<div class="form-box box-shadow">
					<div class="section-heading">
						<h2 class="heading-title">Register</h2>
					</div>
					<form action="/admin-post.php" method="POST">
						<div class="flex-container justified-horizontally">
							<div class="primary-container">
								<h4 class="form-title">About me</h4>
								<div class="form-field-wrapper">
									<input type="text" placeholder="First Name*" name="first_name" />
									<?php maybe_display_error( 'first_name', 'First Name' ); ?>
								</div>
								<div class="form-field-wrapper">
									<input type="text" placeholder="Last Name*" name="last_name" />
									<?php maybe_display_error( 'last_name', 'Last Name' ); ?>
								</div>
								<div class="form-field-wrapper">
									<input type="email" placeholder="Email*" name="email" />
									<?php maybe_display_error( 'email', 'Email' ); ?>
								</div>
								<div class="form-field-wrapper">
									<input type="password" placeholder="Password*" name="password" />
									<?php maybe_display_error( 'password', 'Password' ); ?>
								</div>
								<div class="form-field-wrapper">
									<input type="password" placeholder="Repeat Password*" name="repeat_password" />
									<?php maybe_display_error( 'repeat_password', 'Repeat Password' ); ?>
								</div>
								<div class="form-field-wrapper">
									<input type="text" placeholder="Phone Number" name="phone_number" />
									<?php maybe_display_error( 'phone_number', 'Phone Number' ); ?>
								</div>
							</div>
							<div class="secondary-container">
								<h4 class="form-title">My Company</h4>
								<div class="form-field-wrapper">
									<input type="text" placeholder="Company Name" name="company_name" />
									<?php maybe_display_error( 'company_name', 'Company Name' ); ?>
								</div>
								<div class="form-field-wrapper">
									<input type="text" placeholder="Company Site" name="company_site" />
									<?php maybe_display_error( 'company_site', 'Company Site' ); ?>
								</div>
								<div class="form-field-wrapper">
									<textarea placeholder="Description" name="company_description" ></textarea>
									<?php maybe_display_error( 'company_description', 'Company Description' ); ?>
								</div>
							</div>		
						</div>
						<?php if ( ! empty( $_SESSION['errors'] ) ) : ?>
							<div class="form-field-wrapper">
								<p class="error-message"><?php echo $_SESSION['errors']['message']; ?></p>
							</div>
						<?php endif; ?>				
						<button class="button">
							Register
						</button>
						<input type="text" name="action" value="register" style="display: none;">
					</form>
				</div>
			</div>
		</div>
	</section>	
</main>

<?php
require_once( ROOT_DIR . '/template-parts/footer.php' );
unset( $_SESSION['errors'] );
?>
