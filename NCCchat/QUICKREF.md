# 🚀 NCC CHATBOT - QUICK REFERENCE GUIDE

## ⚡ 30-Second Setup

1. **Start XAMPP** → Click "Start" for Apache & MySQL
2. **Open Browser** → Visit `http://localhost/NCCchat`
3. **Done!** → Database creates automatically

---

## 📍 Key Locations

| What | Where |
|------|-------|
| Chatbot Interface | `http://localhost/NCCchat` |
| Main File | `c:\xampp\htdocs\NCCchat\index.php` |
| Database | MySQL: `ncc_chatbot` |
| PHP Admin | `http://localhost/phpmyadmin` |
| Styling | `views/layouts/style.css` |
| JavaScript | `views/layouts/main.js` |

---

## 🎨 Customize in 2 Minutes

### Change School Name
File: `index.php` (Line 17-18)
```html
<h1>Your School Name</h1>
<p>Your Tagline</p>
```

### Change Colors
File: `views/layouts/style.css` (Line 13-14)
```css
background: linear-gradient(135deg, #YOUR-COLOR-1 0%, #YOUR-COLOR-2 100%);
```

Color suggestions:
- Red: `#FF6B6B` to `#C92A2A`
- Blue: `#4C6EF5` to `#1C7ED6`
- Green: `#51CF66` to `#2B8A3E`
- Orange: `#FF922B` to `#D9480F`

### Add FAQ Question
File: `config/db.php` (Around line 65)
```php
["Admissions", "Your Question?", "Your Answer", "keywords"],
```

Then refresh the page!

---

## 🗣️ How to Test

### Test Chat:
1. Type: "What programs does NCC offer?"
2. Bot responds with program information
3. ✅ Success if you get an answer

### Test FAQ:
1. Click FAQ button (top right)
2. Select category (e.g., "Admissions")
3. Click questions to expand answers
4. ✅ Success if answers display

### Test Mobile:
1. Right-click → Inspect (F12)
2. Click phone icon (responsive mode)
3. Try different screen sizes
4. ✅ Success if layout adapts

---

## 🔍 Find Things

### Where to find the files?
```
c:\xampp\htdocs\NCCchat\
├── index.php ...................... Main file
├── config\db.php .................. Database setup
├── models\Conversation.php ........ Messages
├── models\FAQ.php ................. FAQ queries
├── controllers\ChatController.php . Chat API
└── views\layouts\
    ├── style.css .................. Styling
    └── main.js .................... JavaScript
```

### Where are the databases?
- XAMPP → MySQL → `/data/` folder
- Or access via: `http://localhost/phpmyadmin`
- Database name: `ncc_chatbot`

---

## 🐛 Quick Debug Steps

### Problem: "Blank white page"
```
Solution:
1. Press F12 to open Developer Tools
2. Click "Console" tab
3. Look for red error messages
4. Try refreshing the page (Ctrl+R)
5. Check if MySQL is running (XAMPP)
```

### Problem: "Database error"
```
Solution:
1. Open XAMPP Control Panel
2. Make sure MySQL has green "Running" light
3. Check that MySQL port is 3306
4. Refresh the page
```

### Problem: "Messages not sending"
```
Solution:
1. Open F12 Developer Tools
2. Click "Network" tab
3. Send a message
4. Look for red requests
5. Check ChatController.php exists
```

### Problem: "Styling looks broken"
```
Solution:
1. Press Ctrl+F5 (hard refresh)
2. Press Ctrl+Shift+Delete (clear cache)
3. Check: http://localhost/NCCchat/views/layouts/style.css
   Should show CSS code, not error
4. Try different browser
```

---

## 📞 Sample Questions to Test

Copy-paste these to test:

```
"What are admission requirements?"
"How much does it cost?"
"What programs are available?"
"Tell me about campus facilities"
"How do I contact the school?"
"Hi"
"Help"
"Thank you"
```

Expected: Bot responds with relevant information

---

## 🔧 Common Customizations

### Add Quick Button
File: `index.php` (After line 47)
```html
<button class="quick-btn" onclick="quickQuestion('Your Question')">
    <i class="fas fa-icon-name"></i> Button Text
</button>
```
Icons: https://fontawesome.com

### Change Welcome Message
File: `index.php` (Line 33-34)
```html
<h2>Your Custom Title! 👋</h2>
<p>Your custom subtitle here</p>
```

### Change Response Template
File: `controllers/ChatController.php` (Line 110-120)
Modify the `generateBotResponse()` function

---

## 📊 Database Quick Reference

### View conversations:
```sql
SELECT * FROM conversations;
```

### View all messages:
```sql
SELECT * FROM messages;
```

### View all FAQ:
```sql
SELECT * FROM faq;
```

### Add new FAQ:
```sql
INSERT INTO faq (category, question, answer, keywords) 
VALUES ('Admissions', 'Question?', 'Answer', 'keywords');
```

### Update FAQ:
```sql
UPDATE faq SET answer = 'New answer' WHERE id = 1;
```

### Delete FAQ:
```sql
DELETE FROM faq WHERE id = 1;
```

---

## 🎯 Feature Checklist

- ✅ Chat works
- ✅ FAQ displays
- ✅ Database saves messages
- ✅ Mobile responsive
- ✅ Looks professional
- ✅ Fast loading
- ✅ Easy to customize

---

## 📚 Documentation Files

| File | Purpose |
|------|---------|
| README.md | Complete documentation |
| SETUP.md | Quick start guide |
| CONFIG.md | Configuration details |
| SUMMARY.md | Project overview |
| CHECKLIST.md | Installation checklist |
| **This file** | **Quick reference** |

Read README.md for complete info!

---

## 🚀 Next Level Customizations

### Add Email Notifications
Requires: PHP mail function setup

### Add User Registration
Requires: Additional database table

### Add Voice Chat
Requires: Web Audio API + backend

### Add Admin Panel
Requires: Authentication + database queries

### Add Multiple Languages
Requires: Language files + translation logic

---

## ⏱️ Estimated Time

- **Setup**: 2 minutes
- **First test**: 5 minutes
- **Basic customization**: 10 minutes
- **Advanced features**: 1-2 hours

---

## 💾 Backup Your Data

### Before making changes:
1. Download `config/db.php`
2. Download `views/layouts/style.css`
3. Export database from phpmyadmin
4. Keep copies in safe place

---

## 📞 Need Help?

1. **Read documentation**: README.md
2. **Check troubleshooting**: CONFIG.md
3. **Inspect errors**: Press F12, check Console
4. **Review code**: Each file has comments

---

## ✨ Pro Tips

1. **Use phpmyadmin**: Easier to manage FAQ
2. **Test on mobile**: Resize browser or use phone
3. **Check console errors**: F12 → Console tab
4. **Use Chrome DevTools**: Best for debugging
5. **Comment your changes**: For future reference

---

## 🎓 Learning Resources

- **CSS**: https://developer.mozilla.org/en-US/docs/Web/CSS
- **JavaScript**: https://developer.mozilla.org/en-US/docs/Web/JavaScript
- **PHP**: https://www.php.net/manual/
- **MySQL**: https://dev.mysql.com/doc/
- **Font Awesome**: https://fontawesome.com

---

## 📈 Performance Tips

- Use `http://localhost:3306` direct connection
- Cache FAQ data if many requests
- Minify CSS/JS for production
- Use CDN for Font Awesome (already done)
- Keep database indexes updated

---

## 🔐 Security Checklist

- ✅ Use prepared statements (done)
- ✅ Validate input (done)
- ✅ Escape output (done)
- ⚠️ Use HTTPS in production
- ⚠️ Use strong DB password
- ⚠️ Restrict access to admin files

---

## 📱 Mobile Testing

1. Right-click on page → Inspect
2. Click phone icon (top-left of DevTools)
3. Select mobile device
4. Test at different sizes:
   - iPhone (375px)
   - iPad (768px)
   - Desktop (1200px+)

---

## ✅ Final Checklist

- [ ] XAMPP installed and running
- [ ] MySQL started (green light)
- [ ] Apache started (green light)
- [ ] Can access: http://localhost/NCCchat
- [ ] Page loads without errors
- [ ] Can send messages
- [ ] FAQ sidebar works
- [ ] Database exists
- [ ] Mobile view works
- [ ] Ready to customize!

---

**Status: ✅ READY TO USE**

Start XAMPP and visit: **http://localhost/NCCchat**

Enjoy your NCC Chatbot! 🎉
