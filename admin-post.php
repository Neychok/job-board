<?php

include 'header.php';

if ($_POST['action'] == 'approve') {
    $stmt = $conn->prepare("UPDATE jobs SET status = 1 WHERE id = ?");
	$stmt->bind_param('s', $_POST['job']);
	$stmt->execute();
}

if ($_POST['action'] == 'reject') {
    $stmt = $conn->prepare("UPDATE jobs SET status = 0 WHERE id = ?");
	$stmt->bind_param('s', $_POST['job']);
	$stmt->execute();
}

if($_POST['action'] == 'delete'){
    $stmt = $conn->prepare("DELETE FROM jobs_categories
                            WHERE job_id=?");
	$stmt->bind_param('s', $_POST['job']);
	$stmt->execute();

    $stmt = $conn->prepare("DELETE FROM applications
                            WHERE job_id=?");
	$stmt->bind_param('s', $_POST['job']);
	$stmt->execute();

    $stmt = $conn->prepare("DELETE FROM jobs
                            WHERE id=?");
	$stmt->bind_param('s', $_POST['job']);
	$stmt->execute();
}

if($_POST['action'] == 'delete-submission'){
    $stmt = $conn->prepare("DELETE FROM applications
                            WHERE applications.id=?");
	$stmt->bind_param('s', $_POST['application']);
	$stmt->execute();
}