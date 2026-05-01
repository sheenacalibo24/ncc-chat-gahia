# 🔧 Connection Error - Troubleshooting Guide

## ❌ Common Connection Error

If you see this error:
```
Database connection failed: Connection refused
```

This means **MySQL is not running or not accessible**.

---

## ✅ Solution 1: Start MySQL in XAMPP (Most Common)

### For Windows:

**Step 1: Open XAMPP Control Panel**
- Find XAMPP installation folder (usually `C:\xampp`)
- Double-click `xampp-control.exe`

**Step 2: Start MySQL Service**
- Look for "MySQL" in the control panel
- Click the "Start" button next to MySQL
- Wait 5 seconds for it to start (should turn green)

**Step 3: Verify It's Running**
- MySQL button should be highlighted/green
- You should see "Port 3306" in the information area

**Step 4: Try Again**
- Visit `http://localhost/NCCchat/`
- Or visit `http://localhost/NCCchat/test-connection.php` to test

---

## ✅ Solution 2: Check MySQL Credentials

If MySQL is running but still getting connection error:

### Edit Database Configuration

**File**: `config/db.php`

```php
define('DB_HOST', 'localhost');  // Usually correct
define('DB_USER', 'root');        // Check this
define('DB_PASS', '');            // Check this (empty by default)
define('DB_NAME', 'ncc_chatbot');
```

**Common Issues**:
- **Wrong username**: Check XAMPP MySQL settings
- **Password set**: If MySQL has a password, add it: `define('DB_PASS', 'your-password');`
- **Wrong host**: If using remote MySQL, change `'localhost'` to the server address

---

## ✅ Solution 3: Verify MySQL is Installed

**Check if MySQL is installed:**

1. Open XAMPP Control Panel
2. Look for MySQL service
3. If not listed, you need to reinstall XAMPP with MySQL

---

## ✅ Solution 4: Check Port 3306

MySQL uses port 3306. If blocked:

**Windows Firewall:**
1. Go to Windows Defender Firewall
2. Click "Allow an app through firewall"
3. Look for "MySQL" or "XAMPP"
4. Make sure it's allowed for both Private and Public

**Reset Port:**
1. Stop MySQL in XAMPP
2. Wait 10 seconds
3. Start MySQL again

---

## ✅ Solution 5: Test Connection

### Use the Test File

We've created a test file to help diagnose the issue:

**Visit**: `http://localhost/NCCchat/test-connection.php`

This will show:
- ✓ If MySQLi is loaded
- ✓ If MySQL is running
- ✓ If database exists
- ✓ If tables are created
- ✓ If admin account is set up

### Expected Output:
```
✓ MySQLi extension is loaded
✓ Connected to MySQL successfully!
✓ Database 'ncc_chatbot' ready
✓ Database selected successfully
✓ Table 'conversations' exists
✓ Table 'messages' exists
✓ Table 'faq' exists
✓ Table 'admin_users' exists
✓ Table 'announcements' exists
✓ Table 'chat_analytics' exists
✓ Found 20 FAQ entries
✓ Admin account exists
  Username: admin
```

---

## 📋 Quick Checklist

- [ ] XAMPP is installed
- [ ] XAMPP Control Panel is open
- [ ] MySQL service is started (green button)
- [ ] Apache service is started (green button)
- [ ] Port 3306 is not blocked
- [ ] Database credentials are correct
- [ ] `config/db.php` has correct settings
- [ ] Browser can reach `http://localhost`
- [ ] Test page shows all ✓ marks

---

## 🔍 Advanced Debugging

### Check MySQL Logs

**MySQL Error Log**: `C:\xampp\mysql\data\mysql_error.log`

Look for any error messages there.

### Verify MySQL is Accessible

**From Command Line:**
```cmd
cd C:\xampp\mysql\bin
mysql -u root
```

If this works, MySQL is running correctly.

---

## 🆘 If Still Getting Error

**Try These Steps in Order:**

1. **Restart XAMPP**
   - Close XAMPP Control Panel
   - Wait 30 seconds
   - Open XAMPP Control Panel again
   - Start Apache and MySQL

2. **Clear Browser Cache**
   - Press `Ctrl + Shift + Delete`
   - Clear all cache and cookies
   - Try again

3. **Check Another Browser**
   - Try Chrome, Firefox, or Edge
   - Some browsers cache connection errors

4. **Restart Computer**
   - Restart Windows
   - Reinstall XAMPP if needed

5. **Check XAMPP Installation**
   - Make sure XAMPP is installed in proper location
   - Run as Administrator

---

## 📞 Still Having Issues?

**Check These Files:**

1. `test-connection.php` - Run to see detailed error
2. `config/db.php` - Verify database credentials
3. `admin.php` - Check console for errors (F12)
4. XAMPP Control Panel logs

---

## ✨ Common Solutions Summary

| Error | Solution |
|-------|----------|
| Connection refused | Start MySQL in XAMPP |
| Access denied (user) | Check DB_USER in config/db.php |
| Access denied (password) | Check DB_PASS in config/db.php |
| Unknown database | Delete `config/db.php` temp files |
| Can't connect to server | Check Windows Firewall |
| Port 3306 in use | Another app using MySQL port |

---

## 🎯 Next Steps After Fix

Once connection is working:

1. Visit `http://localhost/NCCchat/`
2. Start using the chatbot
3. Login to admin at `http://localhost/NCCchat/admin.php`
4. Use credentials: `admin` / `ncc123456`

---

**Version**: 1.0  
**Created**: 2024  
**For**: NCC Chatbot System
