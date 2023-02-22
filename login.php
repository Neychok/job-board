<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php';

$err = array(
	'email_err' => "",
	'password_err' => "",
	'other_err' => ""
);
if(!empty($_COOKIE['email']) && !empty($_COOKIE['cookie_hash'])){
	$stmt = $conn->prepare("select * from users where email = ?");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if(empty($row)){
			echo "0 results";
		}
	}
	if(isset($row['cookie_hash'])){
		if($_COOKIE['cookie_hash'] == $row['cookie_hash']){
			$_SESSION['email'] = $row['email'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['logged_in'] = true;
			header("Location: index.php");
			exit();
		}else{
			echo "cookie hash failed";
		}
	}
	
}else{
	if(isset($_POST)){
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$email = validate($_POST['email']);
			$pass = validate($_POST['password']);
			if (empty($email)) {
				$err['email_err'] = "You must enter an email!";
		
			}else if(empty($pass)){
				$err['password_err'] = "You must enter a password!";
		
			}else{
				$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();
				if (mysqli_num_rows($result) === 1) {
					$row = mysqli_fetch_assoc($result);
					if ($row['email'] === $email && password_verify($pass, $row['password'])) {
						if(isset($_POST['remember'])){
							$cookie_hash = password_hash(rand(0,1000000), PASSWORD_DEFAULT);
							$stmt = $conn->prepare("update users set cookie_hash = ? where email = ?");
							$stmt->bind_param("ss", $cookie_hash, $email);
							$stmt->execute();
							setCookie('cookie_hash', $cookie_hash, time()+60*60*7);
						}
						$_SESSION['email'] = $email;
						$_SESSION['id'] = $row['id'];
						header("Location: index.php");
						exit();
					}else{
						$err['other_err'] = "Incorect email or password";
					}
				}else{
					$err['other_err'] = "Incorect email or password";
				}
			}
		}
	}
}
?>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-login">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">Login</h2>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
								<div class="form-field-wrapper">
									<input type="text" name="email" id="email" placeholder="Email"/>
									<span style="color: red" class="error">  <?php echo $err["email_err"];?> </span>
								</div>
								<div class="form-field-wrapper">
									<input type="password" name="password" id="password" placeholder="Password"/>
									<span style="color: red" class="error">  <?php echo $err["password_err"];?> </span>
								</div>
								<div>
									<span style="color: red" class="error">  <?php echo $err["other_err"];?> </span>
								</div>
								<div>
									<tr><td colspan="2" allign="center">
									<input type="checkbox" name="remember" value="1">Remember me</input>
									</td></td>
								</div>
								<button type="submit" class="button">
									Login
								</button>
							</form>
							<a href="#" class="button button-inline">Forgot Password</a>
						</div>
					</div>
				</div>
			</section>	
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>