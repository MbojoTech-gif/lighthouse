<?php
// Include the database connection
include('../db.php'); // Adjust the path if necessary

// Ensure the connection is successful
if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all applications
$apps = $conn->query("SELECT * FROM applications ORDER BY submitted_at DESC");

if (!$apps) {
  die("Query failed: " . $conn->error);
}
?>

<h2 style="font-size:24px; margin-bottom:10px;">Manage Applications</h2>

<table style="width:100%; border-collapse: collapse; font-family: Arial, sans-serif;" border="1">
  <thead>
    <tr style="background:#f0f0f0;">
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Position</th>
      <th>Resume</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($app = $apps->fetch_assoc()): ?>
      <tr>
        <td style="padding:8px;"><?= htmlspecialchars($app['applicant_name']) ?></td>
        <td style="padding:8px;"><?= htmlspecialchars($app['email']) ?></td>
        <td style="padding:8px;"><?= htmlspecialchars($app['phone'] ?? '-') ?></td>
        <td style="padding:8px;"><?= htmlspecialchars($app['position_applied']) ?></td>
        <td style="padding:8px;">
          <?php if (!empty($app['resume_path'])): ?>
            <a href="<?= htmlspecialchars($app['resume_path']) ?>" target="_blank">Download</a>
          <?php else: ?>
            <em>No file</em>
          <?php endif; ?>
        </td>
        <td style="padding:8px;">
          <?php if ($app['status'] === 'approved'): ?>
            <span style="color: green;">Approved</span>
          <?php elseif ($app['status'] === 'rejected'): ?>
            <span style="color: red;">Rejected</span>
          <?php else: ?>
            <span style="color: orange;">Pending</span>
          <?php endif; ?>
        </td>
        <td style="padding:8px;">
          <?php if ($app['status'] === 'pending'): ?>
            <form method="post" action="update_application.php" style="display:inline-block;">
              <input type="hidden" name="id" value="<?= $app['id'] ?>">
              <button name="action" value="approve" style="background:green; color:white; border:none; padding:5px 10px; cursor:pointer;">Approve</button>
              <button name="action" value="reject" style="background:red; color:white; border:none; padding:5px 10px; margin-left:5px; cursor:pointer;">Reject</button>
            </form>
          <?php else: ?>
            <em>N/A</em>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
