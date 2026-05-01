<?php
// Admin Login Debug Page

echo "=== NCC Admin Login Diagnostics ===\n\n";

// Test 1: Database connection
echo "1. Database Connection:\n";
require_once 'config/db.php';

if ($conn->connect_error) {
    echo "   ✗ Failed: " . $conn->connect_error . "\n";
    exit;
}
echo "   ✓ Connected\n";

// Test 2: Check admin_users table
echo "\n2. Checking admin_users table:\n";
$result = $conn->query("SELECT * FROM admin_users");
if (!$result) {
    echo "   ✗ Table error: " . $conn->error . "\n";
    exit;
}

$admin_count = $result->num_rows;
echo "   ✓ Found " . $admin_count . " admin account(s)\n";

if ($admin_count > 0) {
    echo "\n   Admin Accounts:\n";
    while ($row = $result->fetch_assoc()) {
        echo "   - Username: " . $row['username'] . "\n";
        echo "     Email: " . $row['email'] . "\n";
        echo "     Role: " . $row['role'] . "\n";
        echo "     Active: " . ($row['is_active'] ? 'Yes' : 'No') . "\n";
        echo "     Password Hash: " . substr($row['password'], 0, 20) . "...\n";
    }
} else {
    echo "   ✗ No admin accounts found! Creating default account...\n";
    
    $username = 'admin';
    $password = password_hash('ncc123456', PASSWORD_BCRYPT);
    $email = 'admin@nccebu.edu.ph';
    $role = 'admin';
    
    $stmt = $conn->prepare("INSERT INTO admin_users (username, password, email, role, is_active) VALUES (?, ?, ?, ?, 1)");
    if ($stmt) {
        $stmt->bind_param("ssss", $username, $password, $email, $role);
        if ($stmt->execute()) {
            echo "   ✓ Admin account created successfully!\n";
            echo "     Username: admin\n";
            echo "     Password: ncc123456\n";
        } else {
            echo "   ✗ Failed to create admin: " . $stmt->error . "\n";
        }
    } else {
        echo "   ✗ Prepare failed: " . $conn->error . "\n";
    }
}

// Test 3: Test password verification
echo "\n3. Testing Password Verification:\n";
$test_password = 'ncc123456';
$result = $conn->query("SELECT password FROM admin_users WHERE username = 'admin' LIMIT 1");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_hash = $row['password'];
    
    if (password_verify($test_password, $stored_hash)) {
        echo "   ✓ Password verification works\n";
    } else {
        echo "   ✗ Password verification failed\n";
        echo "   Test password: " . $test_password . "\n";
        echo "   Hash: " . $stored_hash . "\n";
    }
} else {
    echo "   ✗ No admin account to test\n";
}

// Test 4: Test login function
echo "\n4. Testing Login Function:\n";
require_once 'models/Admin.php';

$admin = new Admin($conn);
$login_result = $admin->loginAdmin('admin', 'ncc123456');

if ($login_result['success']) {
    echo "   ✓ Login successful!\n";
    echo "     ID: " . $login_result['id'] . "\n";
    echo "     Username: " . $login_result['username'] . "\n";
    echo "     Role: " . $login_result['role'] . "\n";
} else {
    echo "   ✗ Login failed\n";
    echo "     Tried username: admin\n";
    echo "     Tried password: ncc123456\n";
}

// Test 5: Session test
echo "\n5. Testing Session:\n";
session_start();
$_SESSION['admin_id'] = 999;
$_SESSION['admin_username'] = 'testadmin';

if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    echo "   ✓ Sessions work\n";
    echo "     Session ID: " . session_id() . "\n";
} else {
    echo "   ✗ Sessions not working\n";
}

echo "\n=== End of Diagnostics ===\n\n";

// Show what to do next
echo "NEXT STEPS:\n";
echo "1. If all tests passed (✓), try logging in again to admin.php\n";
echo "2. If some tests failed (✗), check the errors above\n";
echo "3. Clear browser cache (Ctrl+Shift+Delete)\n";
echo "4. Try logging in with:\n";
echo "   Username: admin\n";
echo "   Password: ncc123456\n";

$conn->close();
?>
