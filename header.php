<?php 
require_once 'classes/Db-connection.php';
include 'functions.php';

$db = new Requests;
$_SESSION['logged_in'] = false;
$conn = $db->connectDB();
if(!empty($_COOKIE['cookie_hash']) && $_SESSION['logged_in'] == false){
   $cookie_hash = $_COOKIE['cookie_hash'];
   $stmt = $conn->prepare("select id from users where cookie_hash = ?");
   $stmt->bind_param("s", $cookie_hash);
   $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
        if(empty($row)){
            echo "0 results";
        }
    }
    $_SESSION['id'] = $row['id'];
    $_SESSION['logged_in'] = true;
}
if(!empty($_SESSION['id'])){
    $user_id = $_SESSION['id'];
    $_SESSION['logged_in'] = true;
    $_SESSION['is_company'] = false;
    $result = mysqli_query($conn, "SELECT company_name FROM users WHERE id= " . $user_id . " ");
    if ($result->num_rows > 0) $row = $result->fetch_assoc();
    if($row['company_name'] != ""){
        $_SESSION['is_company'] = true;
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/master.css.map">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<header class="site-header">
    <div class="row site-header-inner">
        <div class="site-header-branding">
            <h1 class="site-title"><a href="/index.php">Job Offers</a></h1>
        </div>
        <nav class="site-header-navigation">
            <ul class="menu">
                <li class="menu-item">
                    <a href="/index.php">Home</a>					
                </li>
                <li class="menu-item">
                <?php
                if(!$_SESSION['logged_in']){?>
                    <a href="/register.php">Register</a>
                <?php } else { 
                    if($_SESSION['is_company'] == true){
                    ?>
                    <a href="/dashboard.php">Dashboard</a>
                    <a href="/actions-job.php">Create Job</a>
                    <?php } ?>
                    <a href="/profile.php">My Profile</a>
                <?php } ?></li>
                <li class="menu-item">
                <?php
                if(!$_SESSION['logged_in']){?>
                    <a href="/login.php">Log In</a>
                <?php } else { ?>
                    <a href="/logout.php">Sign Out</a>
                <?php } ?>				
                </li>
            </ul>
        </nav>
        <button class="menu-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path fill="currentColor" class='menu-toggle-bars' d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
        </button>
    </div>
</header>