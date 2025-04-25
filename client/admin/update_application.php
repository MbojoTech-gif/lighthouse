<?php
include('../db.php');

$id = $_POST['id'];
$action = $_POST['action'];

$status = ($action === 'approve') ? 'approved' : 'rejected';

// Fetch applicant info
$stmt = $conn->prepare("SELECT applicant_name, email FROM applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();

// Update status
$update = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
$update->bind_param("si", $status, $id);
$update->execute();

// Send Email
$to = $app['email'];
$subject = "Your Application has been $status";
$message = "Hi {$app['applicant_name']},\n\nYour application has been *$status*.\n\nThank you for your interest in Lighthouse Ministers.";
$headers = "From: admin@tlhm.com";

mail($to, $subject, $message, $headers);

// Redirect back
header("Location: applications.php");
exit;
