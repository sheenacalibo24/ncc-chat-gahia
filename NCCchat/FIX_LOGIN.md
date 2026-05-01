# 🔐 Admin Login Fix - Step by Step

## Problem
Can't login to admin panel with credentials `admin / ncc123456`

## Solution (Try These in Order)

### 🔧 QUICK FIX (Do This First!)

**Option 1: Reset Admin Account**
1. Visit: `http://localhost/NCCchat/reset-admin.php`
2. Follow the instructions on screen
3. Try logging in again with: `admin / ncc123456`

**Option 2: Full Diagnostics**
1. Visit: `http://localhost/NCCchat/admin-debug.php`
2. This will show exactly what's wrong
3. It will automatically fix issues and recreate admin account
4. Try logging in again

---

## ✅ Verify Login Works

### Step 1: Check Database
```
Visit: http://localhost/NCCchat/admin-debug.php
```
Should show: `✓ Admin account exists`

### Step 2: Clear Browser Cache
```
Press: Ctrl + Shift + Delete
Select: All cache and cookies
Clear
```

### Step 3: Try Login
- URL: `http://localhost/NCCchat/admin.php`
- Username: `admin`
- Password: `ncc123456`

### Step 4: Check Browser Console
- Press: `F12` (browser developer tools)
- Click: "Console" tab
- Look for any red error messages
- Take screenshot if there are errors

---

## 📋 Files for Troubleshooting

| File | Purpose |
|------|---------|
| `admin-debug.php` | Full diagnostics - shows everything |
| `reset-admin.php` | Force recreate admin account |
| `test-connection.php` | Test database connection |
| `test-login.php` | Test login function directly |

---

## 🆘 If Still Not Working

1. **Run all three diagnostic files:**
   - `admin-debug.php` - Check database
   - `test-connection.php` - Check connection
   - `test-login.php` - Check login logic

2. **Check these files exist:**
   - `config/db.php`
   - `controllers/AdminController.php`
   - `models/Admin.php`
   - `views/layouts/admin.js`
   - `admin.php`

3. **Verify MySQL is running:**
   - Open XAMPP Control Panel
   - Click "Start" next to MySQL (should be green)
   - Click "Start" next to Apache (should be green)

4. **Take a screenshot:**
   - Open browser console (F12)
   - Take screenshot of any error messages
   - Share it for debugging

---

## 💡 Common Mistakes

- ✗ Typing `Admin` instead of `admin` (must be lowercase)
- ✗ Password `ncc12345` instead of `ncc123456` (must be exactly right)
- ✗ Forgetting to start MySQL in XAMPP
- ✗ Not clearing browser cache
- ✗ Using wrong URL (must be exactly: `http://localhost/NCCchat/admin.php`)

---

## 🚀 Default Credentials

```
Username: admin
Password: ncc123456
```

**IMPORTANT:** These are:
- Lowercase `admin`
- Exactly `ncc123456` (12 characters)
- No spaces before or after

---

## ✓ What Should Happen

1. Visit: `http://localhost/NCCchat/admin.php`
2. See login form
3. Enter: `admin` / `ncc123456`
4. Click: "Login"
5. See: Admin Dashboard with menu on left

If you see anything different, check the diagnostic files.

---

## 📞 Still Need Help?

1. Run: `admin-debug.php`
2. Run: `test-connection.php`
3. Press `F12` in browser
4. Check console for error messages
5. Share the error messages for help

---

**Version:** 1.0  
**Date:** May 2024  
**For:** NCC Chatbot Admin Panel
