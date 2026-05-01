<?php
// Test Database Connection

echo "=== NCC Chatbot - Database Connection Test ===\n\n";

// Test 1: Check if MySQLi extension is loaded
echo "1. Checking MySQLi extension...\n";
if (extension_loaded('mysqli')) {
    echo "   ✓ MySQLi extension is loaded\n";
} else {
    echo "   ✗ MySQLi extension is NOT loaded\n";
}

echo "\n2. Attempting database connection...\n";
echo "   Host: localhost\n";
echo "   User: root\n";
echo "   Password: (empty)\n";
echo "   Database: ncc_chatbot\n\n";

// Test 2: Try basic connection
$conn = @new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    echo "   ✗ Connection Failed!\n";
    echo "   Error: " . $conn->connect_error . "\n";
    echo "\n   TROUBLESHOOTING:\n";
    echo "   - Make sure MySQL is running\n";
    echo "   - Check if XAMPP MySQL service is started\n";
    echo "   - Verify port 3306 is not blocked\n";
    echo "   - Check MySQL credentials\n";
    exit;
}

echo "   ✓ Connected to MySQL successfully!\n";

// Test 3: Create database
echo "\n3. Creating/Selecting database...\n";
if ($conn->query("CREATE DATABASE IF NOT EXISTS ncc_chatbot")) {
    echo "   ✓ Database 'ncc_chatbot' ready\n";
} else {
    echo "   ✗ Error: " . $conn->error . "\n";
    exit;
}

// Test 4: Select database
if ($conn->select_db("ncc_chatbot")) {
    echo "   ✓ Database selected successfully\n";
} else {
    echo "   ✗ Error: " . $conn->error . "\n";
    exit;
}

// Test 5: Check tables
echo "\n4. Checking tables...\n";
$tables_needed = ['conversations', 'messages', 'faq', 'admin_users', 'announcements', 'chat_analytics'];
$result = $conn->query("SHOW TABLES");
$existing_tables = [];
while ($row = $result->fetch_row()) {
    $existing_tables[] = $row[0];
}

foreach ($tables_needed as $table) {
    if (in_array($table, $existing_tables)) {
        echo "   ✓ Table '$table' exists\n";
    } else {
        echo "   ✗ Table '$table' missing\n";
    }
}

// Test 6: Check FAQ data
echo "\n5. Checking FAQ data...\n";
$result = $conn->query("SELECT COUNT(*) as count FROM faq");
if ($result) {
    $row = $result->fetch_assoc();
    echo "   ✓ Found " . $row['count'] . " FAQ entries\n";
} else {
    echo "   ✗ Error: " . $conn->error . "\n";
}

// Test 7: Check admin user
echo "\n6. Checking admin user...\n";
$result = $conn->query("SELECT COUNT(*) as count FROM admin_users");
if ($result) {
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "   ✓ Admin account exists\n";
        $admin = $conn->query("SELECT username FROM admin_users LIMIT 1");
        $admin_row = $admin->fetch_assoc();
        echo "   Username: " . $admin_row['username'] . "\n";
    } else {
        echo "   ✗ No admin account found\n";
    }
} else {
    echo "   ✗ Error: " . $conn->error . "\n";
}

echo "\n=== All Systems Operational ===\n";
echo "\nYou can now access:\n";
echo "- User Chatbot: http://localhost/NCCchat/\n";
echo "- Admin Panel: http://localhost/NCCchat/admin.php\n";
echo "- Admin Credentials: admin / ncc123456\n";

$conn->close();
?>
