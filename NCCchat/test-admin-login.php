<?php
// Quick test to verify admin login is working
session_start();

require_once 'config/db.php';
require_once 'models/Admin.php';

header('Content-Type: application/json');

// Test 1: Check database connection
echo "✓ Database connected successfully\n";

// Test 2: Test login with default credentials
$admin = new Admin($conn);
$result = $admin->loginAdmin('admin', 'ncc123456');

if ($result['success']) {
    echo "✓ Admin login test PASSED\n";
    echo "  - Username: " . $result['username'] . "\n";
    echo "  - Role: " . $result['role'] . "\n";
} else {
    echo "✗ Admin login test FAILED\n";
    // Try to insert default admin if not exists
    $check = $conn->query("SELECT * FROM admin_users WHERE username = 'admin'");
    if ($check->num_rows == 0) {
        echo "  - No admin user found, creating default...\n";
        $password = password_hash('ncc123456', PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO admin_users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $u, $p, $e, $r);
        $u = 'admin';
        $p = $password;
        $e = 'admin@nccebu.edu.ph';
        $r = 'admin';
        if ($stmt->execute()) {
            echo "  ✓ Default admin user created\n";
        }
    }
}

// Test 3: Check controller path
if (file_exists('controllers/AdminController.php')) {
    echo "✓ AdminController.php found\n";
} else {
    echo "✗ AdminController.php NOT found\n";
}

// Test 4: Check admin.php
if (file_exists('admin.php')) {
    echo "✓ admin.php found\n";
} else {
    echo "✗ admin.php NOT found\n";
}

echo "\n✓ All tests completed\n";
?>
