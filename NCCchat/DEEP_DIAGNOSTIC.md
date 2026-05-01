# Deep Diagnostic Guide - NCC Admin Dashboard

## Quick Tests

### 1. **Test Database Connection**
Visit: `http://localhost/NCCchat/test-admin-connection.php`
- This will show all diagnostic information about:
  - PHP version and extensions
  - Database connectivity
  - Table existence
  - Admin user status
  - File structure

### 2. **Test API with Debug Info**
Test login directly:
```
POST http://localhost/NCCchat/controllers/AdminController_DEBUG.php
Parameters:
  action=login
  username=admin
  password=ncc123456
```

### 3. **Browser Console Check** (F12)
1. Open admin.php
2. Press F12 to open DevTools
3. Go to Console tab
4. Look for any error messages
5. Go to Network tab and check:
   - If `AdminController.php` is being called
   - What response it's returning
   - Any HTTP errors (red status codes)

---

## Common Issues & Solutions

### Issue 1: Page Loads but Login Form Doesn't Appear
**Cause:** JavaScript not executing
**Solution:**
1. Check Console (F12) for JS errors
2. Verify `views/layouts/admin.js` exists
3. Clear browser cache: Ctrl+Shift+Delete (Windows)

### Issue 2: Login Button Does Nothing
**Cause:** Fetch request failing or controller error
**Solution:**
1. Open DevTools Network tab
2. Click Login button
3. Check if `AdminController.php` request appears
4. Click the request to see response details

### Issue 3: "Invalid username or password"
**Cause:** Database connection or table issues
**Solution:**
1. Run `test-admin-connection.php`
2. Verify admin_users table has data
3. Check admin user is `is_active = 1`

### Issue 4: "Database connection failed"
**Cause:** PDO or MySQL not working
**Solution:**
1. Verify MySQL/MariaDB is running
2. Check credentials in `config/db.php`:
   - Host: localhost
   - User: root
   - Password: (empty for XAMPP)
   - Database: ncc_chatbot

### Issue 5: White Screen or 500 Error
**Cause:** PHP syntax error or fatal exception
**Solution:**
1. Check PHP error logs:
   - XAMPP: `xampp/apache/logs/error.log`
   - Or check `/controllers/AdminController_DEBUG.php` response
2. Verify all PHP files are properly formatted

---

## Step-by-Step Troubleshooting

### Step 1: Verify Database
```bash
# In MySQL console:
USE ncc_chatbot;
SELECT * FROM admin_users WHERE username='admin';
# Should show password hash starting with $2y$10$
```

### Step 2: Test Connection Script
1. Visit: `http://localhost/NCCchat/test-admin-connection.php`
2. Take note of which checks ✅ pass and which ❌ fail
3. If database checks fail, MySQL might not be running

### Step 3: Test API Response
1. Use a tool like Postman or curl
2. Send POST request to:
   - URL: `http://localhost/NCCchat/controllers/AdminController_DEBUG.php`
   - Body (form-data):
     ```
     action=check_status
     ```
3. Should return JSON with `logged_in: false`

### Step 4: Test Login
```bash
# Using curl:
curl -X POST http://localhost/NCCchat/controllers/AdminController_DEBUG.php \
  -d "action=login&username=admin&password=ncc123456"

# Should return JSON with status: success
```

### Step 5: Check Browser Console
1. Open admin.php
2. Press F12
3. Go to Console tab
4. Type `checkAdminStatus()` and press Enter
5. Watch console for errors

---

## Key Files to Check

| File | Purpose | Status |
|------|---------|--------|
| `config/db.php` | Database configuration | Check credentials |
| `models/Admin.php` | Admin class (PDO) | Check syntax |
| `controllers/AdminController.php` | API handler | Check connection init |
| `admin.php` | Main page | Check if loads |
| `views/layouts/admin.js` | Frontend logic | Check console errors |

---

## Quick Fixes to Try

### Fix 1: Clear Cache
- Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)
- Or open in private/incognito window

### Fix 2: Restart MySQL/Apache
- XAMPP Control Panel → Stop MySQL → Start MySQL
- Stop Apache → Start Apache

### Fix 3: Check Database Exists
In MySQL:
```sql
SHOW DATABASES;
# Look for 'ncc_chatbot'

USE ncc_chatbot;
SHOW TABLES;
# Should show: admin_users, announcements, etc.
```

### Fix 4: Verify Admin User
```sql
SELECT * FROM admin_users WHERE username='admin';
# Check if password is NOT NULL and is_active=1
```

### Fix 5: Test Password
The default password `ncc123456` should hash to:
```
$2y$10$EpxpvINDf5Vhcj.D4yScHuuwHcSyz.gwtVdMNgW6lOl4bcXTqti9a
```

Verify with PHP:
```php
<?php
$hash = '$2y$10$EpxpvINDf5Vhcj.D4yScHuuwHcSyz.gwtVdMNgW6lOl4bcXTqti9a';
echo password_verify('ncc123456', $hash) ? 'Valid' : 'Invalid';
?>
```

---

## Advanced Debugging

### Enable Detailed Error Logging
Edit `config/db.php`:
```php
// Add after getConnection():
$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### Add Console Logs to admin.js
At line 17 in admin.js, add:
```javascript
function checkAdminStatus() {
    console.log('=== CHECK ADMIN STATUS STARTED ===');
    // ... rest of function
    console.log('Response received:', data);
}
```

### Test Direct URL
Try these URLs directly in browser:
- `http://localhost/NCCchat/admin.php` (should load page)
- `http://localhost/NCCchat/controllers/AdminController.php` (should return error JSON)

---

## Contact Info
If issues persist, gather this info:
1. Output from `test-admin-connection.php`
2. Browser console errors (F12)
3. Network tab response from AdminController.php
4. MySQL error log content
5. PHP error log content
