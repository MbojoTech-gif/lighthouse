<h2 style="font-size:24px; margin-bottom:10px;">Manage Applications</h2>

<table style="width:100%; border-collapse: collapse;" border="1">
  <thead>
    <tr style="background:#f0f0f0;">
      <th>Name</th>
      <th>Email</th>
      <th>Position</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($app = $apps->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($app['applicant_name']) ?></td>
        <td><?= htmlspecialchars($app['email']) ?></td>
        <td><?= htmlspecialchars($app['position_applied']) ?></td>
        <td>
          <?php if ($app['status'] === 'approved'): ?>
            <span style="color: green;">Approved</span>
          <?php elseif ($app['status'] === 'rejected'): ?>
            <span style="color: red;">Rejected</span>
          <?php else: ?>
            <span style="color: orange;">Pending</span>
          <?php endif; ?>
        </td>
        <td>
          <?php if ($app['status'] === 'pending'): ?>
            <form method="post" action="update_application.php" style="display:inline">
              <input type="hidden" name="id" value="<?= $app['id'] ?>">
              <button name="action" value="approve" style="background:green; color:white; border:none; padding:5px;">Approve</button>
              <button name="action" value="reject" style="background:red; color:white; border:none; padding:5px;">Reject</button>
            </form>
          <?php else: ?>
            <em>No action</em>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
