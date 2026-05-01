# 🔐 Admin Login Troubleshooting Guide

## Problem: Can't Login to Admin Panel

If you're unable to login with credentials `admin / ncc123456`, follow these steps.

---

## ✅ Step 1: Verify Admin Account Exists

**Check if admin account is properly created in database:**

1. Visit: `http://localhost/NCCchat/admin-debug.php`
2. This page will show:
   - ✓ Database connection status
   - ✓ Admin accounts in database
   - ✓ Password verification test
   - ✓ Session status
   - ✓ Full login test

**Expected Output:**
```
✓ Connected
✓ Found 1 admin account(s)
   Admin Accounts:
   - Username: admin
     Email: admin@nccebu.edu.ph
     Role: admin
     Active: Yes
   ✓ Password verification works
   ✓ Login successful!
```

If the debug page shows errors, the problem is in database or admin setup.

---

## ✅ Step 2: Clear Browser Cache & Cookies

Sometimes cached data causes issues:

1. **Press:** `Ctrl + Shift + Delete` (Chrome/Firefox) or `Cmd + Shift + Delete` (Mac)
2. **Select:**
   - ☑️ Cookies and other site data
   - ☑️ Cached images and files
3. **Click:** "Clear data"
4. **Close** all browser tabs for localhost
5. **Try again:** Visit `http://localhost/NCCchat/admin.php`

---

## ✅ Step 3: Check Browser Console for Errors

The admin panel might be showing errors in the browser console:

1. **Open admin.php:** `http://localhost/NCCchat/admin.php`
2. **Press:** `F12` (or right-click → "Inspect")
3. **Click:** "Console" tab
4. **Look for** red error messages
5. **Take a screenshot** and note any errors

---

## ✅ Step 4: Verify Credentials

The default login is:
```
Username: admin
Password: ncc123456
```

Make sure you're typing it **exactly**:
- ✓ All lowercase: `admin` (not `Admin` or `ADMIN`)
- ✓ Exact password: `ncc123456` (12 characters)
- ✓ No extra spaces before/after

---

## ✅ Step 5: Test Login Function Directly

Use this simple test to verify login works:

**Create file:** `test-login.php`

```php
<?php
require_once 'config/db.php';
require_once 'models/Admin.php';

$admin = new Admin($conn);

// Test login
$result = $admin->loginAdmin('admin', 'ncc123456');

if ($result['success']) {
    echo "✓ LOGIN SUCCESSFUL!\n";
    echo "ID: " . $result['id'] . "\n";
    echo "Username: " . $result['username'] . "\n";
    echo "Role: " . $result['role'] . "\n";
} else {
    echo "✗ LOGIN FAILED\n";
    echo "Tried: admin / ncc123456\n";
    
    // Check if user exists
    $check = $conn->query("SELECT * FROM admin_users WHERE username = 'admin'");
    if ($check->num_rows > 0) {
        echo "User exists but password mismatch\n";
    } else {
        echo "User 'admin' does not exist!\n";
    }
}

$conn->close();
?>
```

Visit: `http://localhost/NCCchat/test-login.php`

Should show: `✓ LOGIN SUCCESSFUL!`

---

## 🔧 Common Issues & Fixes

### Issue 1: "Invalid username or password"

**Cause:** Admin account wasn't created

**Fix:**
1. Visit: `admin-debug.php`
2. It will automatically create admin account
3. Try login again

---

### Issue 2: Sessions not working

**Cause:** PHP sessions are disabled or misconfigured

**Fix:**
1. Open: `php.ini`
2. Check: `session.save_path` is writable
3. Restart XAMPP
4. Try again

---

### Issue 3: Blank page or error

**Cause:** File path or database issue

**Fix:**
1. Check: `config/db.php` exists
2. Check: `controllers/AdminController.php` exists
3. Check: `models/Admin.php` exists
4. Check browser console (F12) for errors
5. Open: `admin-debug.php` for full diagnostics

---

### Issue 4: Login button does nothing

**Cause:** JavaScript error or fetch issue

**Fix:**
1. Open browser console (F12)
2. Look for red errors
3. Try entering credentials and clicking login
4. Note any console messages
5. Refresh page and try again

---

## 🚀 If All Else Fails

### Step 1: Recreate Admin Account

1. Open command prompt in `C:\xampp\mysql\bin`
2. Run:
   ```
   mysql -u root
   USE ncc_chatbot;
   DELETE FROM admin_users;
   ```
3. Visit: `admin-debug.php` - it will recreate admin account
4. Try login again

### Step 2: Reset Entire System

1. Stop XAMPP MySQL
2. Delete file: `C:\xampp\htdocs\NCCchat\config\db.php` (if you modified it)
3. Delete database: `C:\xampp\mysql\data\ncc_chatbot`
4. Start MySQL
5. Visit: `admin-debug.php` - system will reinitialize
6. Try login with: `admin / ncc123456`

---

## 📋 Login Flow Diagram

```
You enter: admin / ncc123456
             ↓
JavaScript: loginAdmin() function
             ↓
Sends to: controllers/AdminController.php (action: login)
             ↓
PHP: Checks username/password
             ↓
Database: Verifies password hash
             ↓
Session: Stores admin_id in $_SESSION
             ↓
Response: Returns success
             ↓
JavaScript: Shows admin panel
             ↓
You see: Admin Dashboard ✓
```

---

## 🔍 Debug Information

**Files involved in login:**
- `admin.php` - Login form HTML
- `views/layouts/admin.js` - Login function
- `controllers/AdminController.php` - Login handler
- `models/Admin.php` - Password verification
- `config/db.php` - Database connection

**Test files created:**
- `admin-debug.php` - Full diagnostics
- `test-connection.php` - Database test
- `test-login.php` - Login function test

---

## ✅ Final Checklist

- [ ] MySQL is running
- [ ] Database exists (`ncc_chatbot`)
- [ ] Admin account exists (run `admin-debug.php`)
- [ ] Browser cache is cleared
- [ ] Credentials are correct (admin / ncc123456)
- [ ] No errors in browser console (F12)
- [ ] Credentials typed exactly (lowercase, no spaces)
- [ ] All required files exist in correct folders

---

## 📞 Support

If you're still having issues:

1. **Run:** `admin-debug.php` and copy all output
2. **Check:** Browser console (F12) for errors
3. **Verify:** All files exist in correct locations
4. **Test:** Database connection with `test-connection.php`
5. **Restart:** XAMPP MySQL and Apache services

---

**Default Login Credentials:**
- Username: `admin`
- Password: `ncc123456`

**Remember:** All lowercase, exact spelling!

---

*For additional help, check the console output (F12) or visit the debug pages.*
