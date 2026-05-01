<?php
/**
 * ADMIN ACCOUNT RESET
 * 
 * This file will recreate the admin account with default credentials
 * Use only if you've forgotten the password or can't login
 */

echo "=== NCC Admin Account Reset ===\n\n";

require_once 'config/db.php';

echo "1. Checking database connection...\n";
if ($conn->connect_error) {
    die("   ✗ Database error: " . $conn->connect_error . "\n");
}
echo "   ✓ Connected\n";

echo "\n2. Deleting existing admin accounts...\n";
$delete_result = $conn->query("DELETE FROM admin_users WHERE username = 'admin'");
if ($delete_result) {
    echo "   ✓ Old admin account removed\n";
} else {
    echo "   ✗ Error: " . $conn->error . "\n";
}

echo "\n3. Creating new admin account...\n";
$admin_user = 'admin';
$admin_pass = password_hash('ncc123456', PASSWORD_BCRYPT);
$admin_email = 'admin@nccebu.edu.ph';
$admin_role = 'admin';

$stmt = $conn->prepare("INSERT INTO admin_users (username, password, email, role, is_active) VALUES (?, ?, ?, ?, 1)");
if ($stmt) {
    $stmt->bind_param("ssss", $admin_user, $admin_pass, $admin_email, $admin_role);
    if ($stmt->execute()) {
        echo "   ✓ Admin account created successfully!\n";
        $stmt->close();
    } else {
        echo "   ✗ Error: " . $stmt->error . "\n";
        exit;
    }
} else {
    echo "   ✗ Prepare error: " . $conn->error . "\n";
    exit;
}

echo "\n4. Verifying admin account...\n";
$verify = $conn->query("SELECT * FROM admin_users WHERE username = 'admin' LIMIT 1");
if ($verify && $verify->num_rows > 0) {
    $admin = $verify->fetch_assoc();
    echo "   ✓ Admin account verified!\n";
    echo "     Username: " . $admin['username'] . "\n";
    echo "     Email: " . $admin['email'] . "\n";
    echo "     Role: " . $admin['role'] . "\n";
    echo "     Active: " . ($admin['is_active'] ? 'Yes' : 'No') . "\n";
} else {
    echo "   ✗ Verification failed\n";
    exit;
}

echo "\n5. Testing password...\n";
if (password_verify('ncc123456', $admin['password'])) {
    echo "   ✓ Password verification successful\n";
} else {
    echo "   ✗ Password verification failed\n";
}

echo "\n" . str_repeat("=", 40) . "\n";
echo "✓ ADMIN ACCOUNT RESET COMPLETE\n";
echo str_repeat("=", 40) . "\n";

echo "\nNew Credentials:\n";
echo "Username: admin\n";
echo "Password: ncc123456\n";

echo "\nNext Steps:\n";
echo "1. Clear browser cache (Ctrl+Shift+Delete)\n";
echo "2. Go to: http://localhost/NCCchat/admin.php\n";
echo "3. Login with the credentials above\n";
echo "4. Change the password in admin panel (if available)\n";

$conn->close();

echo "\n✓ Done!\n";
?>
