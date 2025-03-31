<?php
// settings.php - Manage Site Settings
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Fetch current settings
$settings_query = $conn->query("SELECT * FROM settings LIMIT 1");
$settings = $settings_query->fetch_assoc();

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_name = $_POST['site_name'];
    $contact_email = $_POST['contact_email'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $whatsapp = $_POST['whatsapp'];
    $youtube = $_POST['youtube'];
    $tiktok = $_POST['tiktok'];
    
    if ($settings) {
        $stmt = $conn->prepare("UPDATE settings SET site_name = ?, contact_email = ?, facebook = ?, twitter = ?, instagram = ?, whatsapp = ?, youtube = ?, tiktok = ? WHERE id = 1");
        $stmt->bind_param("ssssssss", $site_name, $contact_email, $facebook, $twitter, $instagram, $whatsapp, $youtube, $tiktok);
    } else {
        $stmt = $conn->prepare("INSERT INTO settings (site_name, contact_email, facebook, twitter, instagram, whatsapp, youtube, tiktok) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $site_name, $contact_email, $facebook, $twitter, $instagram, $whatsapp, $youtube, $tiktok);
    }
    
    $stmt->execute();
    $stmt->close();
    header("Location: settings.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Settings</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="settings-container">
        <h2>Site Settings</h2>
        <form method="POST">
            <label>Site Name:</label>
            <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>" required><br>
            
            <label>Contact Email:</label>
            <input type="email" name="contact_email" value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>" required><br>
            
            <label>Facebook Link:</label>
            <input type="url" name="facebook" value="<?php echo htmlspecialchars($settings['facebook'] ?? ''); ?>"><br>
            
            <label>Twitter Link:</label>
            <input type="url" name="twitter" value="<?php echo htmlspecialchars($settings['twitter'] ?? ''); ?>"><br>
            
            <label>Instagram Link:</label>
            <input type="url" name="instagram" value="<?php echo htmlspecialchars($settings['instagram'] ?? ''); ?>"><br>
            
            <label>WhatsApp Link:</label>
            <input type="url" name="whatsapp" value="<?php echo htmlspecialchars($settings['whatsapp'] ?? ''); ?>"><br>
            
            <label>YouTube Link:</label>
            <input type="url" name="youtube" value="<?php echo htmlspecialchars($settings['youtube'] ?? ''); ?>"><br>
            
            <label>TikTok Link:</label>
            <input type="url" name="tiktok" value="<?php echo htmlspecialchars($settings['tiktok'] ?? ''); ?>"><br>
            
            <button type="submit">Save Settings</button>
        </form>
    </div>
</body>
</html>