<?php
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 NCC Admin Dashboard - Diagnostic Check</h2>";
echo "<hr>";

// 1. Check PHP Version
echo "<h3>1. PHP Version</h3>";
echo "PHP Version: <strong>" . phpversion() . "</strong><br>";

// 2. Check PDO
echo "<h3>2. PDO Extension</h3>";
if (extension_loaded('pdo')) {
    echo "✅ PDO extension loaded<br>";
    if (extension_loaded('pdo_mysql')) {
        echo "✅ PDO MySQL driver loaded<br>";
    } else {
        echo "❌ PDO MySQL driver NOT loaded<br>";
    }
} else {
    echo "❌ PDO extension NOT loaded<br>";
}

// 3. Test Database Connection
echo "<h3>3. Database Connection Test</h3>";
require_once 'config/db.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "✅ Database connection successful<br>";
        
        // Check if admin_users table exists
        try {
            $result = $conn->query("SELECT COUNT(*) as count FROM admin_users");
            $data = $result->fetch(PDO::FETCH_ASSOC);
            echo "✅ admin_users table exists<br>";
            echo "   Total admin users: <strong>" . $data['count'] . "</strong><br>";
            
            // Get admin user details
            $result = $conn->query("SELECT id, username, email FROM admin_users WHERE is_active = 1");
            $admins = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($admins) {
                echo "   Active admins:<br>";
                foreach ($admins as $admin) {
                    echo "   - Username: <strong>" . htmlspecialchars($admin['username']) . "</strong><br>";
                }
            }
        } catch (Exception $e) {
            echo "❌ Error querying admin_users: " . $e->getMessage() . "<br>";
        }
        
        // Check FAQ table
        try {
            $result = $conn->query("SELECT COUNT(*) as count FROM faq");
            $data = $result->fetch(PDO::FETCH_ASSOC);
            echo "✅ faq table exists<br>";
            echo "   Total FAQs: <strong>" . $data['count'] . "</strong><br>";
        } catch (Exception $e) {
            echo "❌ Error querying faq: " . $e->getMessage() . "<br>";
        }
        
        // Check conversations table
        try {
            $result = $conn->query("SELECT COUNT(*) as count FROM conversations");
            $data = $result->fetch(PDO::FETCH_ASSOC);
            echo "✅ conversations table exists<br>";
            echo "   Total conversations: <strong>" . $data['count'] . "</strong><br>";
        } catch (Exception $e) {
            echo "❌ Error querying conversations: " . $e->getMessage() . "<br>";
        }
        
    } else {
        echo "❌ Database connection failed<br>";
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "<br>";
}

// 4. Test Admin Model
echo "<h3>4. Admin Model Test</h3>";
try {
    require_once 'models/Admin.php';
    if (class_exists('Admin')) {
        echo "✅ Admin class loaded successfully<br>";
        $admin = new Admin($conn);
        echo "✅ Admin object created successfully<br>";
    } else {
        echo "❌ Admin class not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error loading Admin class: " . $e->getMessage() . "<br>";
}

// 5. Test API Endpoint
echo "<h3>5. AdminController API Test</h3>";
echo "Check status endpoint: <code>./controllers/AdminController.php?action=check_status</code><br>";
echo "This should return JSON response<br>";

// 6. Session Check
echo "<h3>6. Session Management</h3>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "✅ Session status: " . (session_status() === PHP_SESSION_ACTIVE ? "ACTIVE" : "INACTIVE") . "<br>";
echo "Session ID: <strong>" . session_id() . "</strong><br>";

// 7. Test Login
echo "<h3>7. Test Login Function</h3>";
echo "Test credentials: admin / ncc123456<br>";
if ($conn && class_exists('Admin')) {
    try {
        $admin = new Admin($conn);
        $result = $admin->loginAdmin('admin', 'ncc123456');
        if ($result['success']) {
            echo "✅ Login test successful<br>";
            echo "   User: " . $result['username'] . "<br>";
            echo "   ID: " . $result['id'] . "<br>";
        } else {
            echo "❌ Login test failed - invalid credentials or user inactive<br>";
        }
    } catch (Exception $e) {
        echo "❌ Login test error: " . $e->getMessage() . "<br>";
    }
}

// 8. File Permissions
echo "<h3>8. File Structure</h3>";
$files = [
    'admin.php',
    'controllers/AdminController.php',
    'controllers/ChatController.php',
    'models/Admin.php',
    'models/Conversation.php',
    'models/FAQ.php',
    'config/db.php',
    'views/layouts/admin.js'
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✅ " . $file . " exists<br>";
    } else {
        echo "❌ " . $file . " missing<br>";
    }
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>If all checks are ✅, try clearing browser cache and refreshing</li>";
echo "<li>Open browser DevTools (F12) and check the Console tab for JavaScript errors</li>";
echo "<li>Check Network tab to see if AdminController.php is responding</li>";
echo "<li>If database checks fail, ensure MySQL/MariaDB is running</li>";
echo "</ol>";

?>
