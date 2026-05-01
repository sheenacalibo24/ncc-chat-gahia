# 📋 NCC Chatbot - Configuration Reference

## 🚀 QUICK START

1. Start XAMPP (Apache + MySQL)
2. Visit: `http://localhost/NCCchat`
3. Database creates automatically on first visit
4. Start chatting! 💬

---

## 📁 FILE STRUCTURE

```
NCCchat/
├── 📄 index.php                    ← Main chatbot interface
├── 📄 README.md                    ← Full documentation
├── 📄 SETUP.md                     ← Quick start guide
├── 📁 config/
│   └── 📄 db.php                  ← Database setup & FAQs
├── 📁 models/
│   ├── 📄 Conversation.php        ← Message handling
│   └── 📄 FAQ.php                 ← FAQ queries
├── 📁 controllers/
│   └── 📄 ChatController.php      ← API endpoints
└── 📁 views/
    └── 📁 layouts/
        ├── 📄 style.css           ← Styling
        └── 📄 main.js             ← JavaScript logic
```

---

## 🗄️ DATABASE

**Name**: `ncc_chatbot`  
**User**: `root`  
**Password**: (empty by default)  
**Host**: `localhost`

### Tables Created:
1. **conversations** - Stores chat sessions
2. **messages** - Stores all messages
3. **faq** - Stores FAQ data

---

## 🎨 CUSTOMIZATION

### Change Database Credentials
Edit `config/db.php` (lines 2-4):
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Add FAQ Questions
Edit `config/db.php` (lines 64-80) or use SQL:
```sql
INSERT INTO faq (category, question, answer, keywords) 
VALUES ('Admissions', 'Your Question?', 'Your Answer', 'keywords');
```

### Change Colors
Edit `views/layouts/style.css`:
```css
/* Line 13-14 - Main gradient */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Line 42-43 - Header gradient */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Modify Chatbot Name
Edit `index.php` (lines 20-22):
```html
<h1>NCC Chatbot</h1>
<p>Northeastern Cebu Colleges</p>
```

---

## 🔧 API ENDPOINTS

### Send Message
```
POST /controllers/ChatController.php
action=send_message
session_id=ncc_xxxx
message=Your question here
user_name=John Doe
```

### Get FAQ
```
GET /controllers/ChatController.php?action=get_faq&category=Admissions
GET /controllers/ChatController.php?action=get_categories
```

---

## 📱 RESPONSIVE DESIGN

The chatbot is optimized for:
- 💻 Desktop (1200px+)
- 📱 Tablet (768px-1200px)
- 📲 Mobile (360px-768px)

---

## 🔍 FAQ CATEGORIES

Current categories:
1. **Admissions** - Requirements, process, programs
2. **Finance** - Tuition, scholarships, fees
3. **Campus Life** - Facilities, activities, clubs
4. **Academic** - Calendar, support services
5. **Contact** - Phone, email, location

---

## 🛡️ SECURITY NOTES

- ✅ SQL Prepared Statements (prevents injection)
- ✅ Unique Session IDs
- ✅ Input Validation
- ✅ Output Escaping
- ⚠️ Use HTTPS in production

---

## 🐛 TROUBLESHOOTING

| Issue | Solution |
|-------|----------|
| Blank page | Check F12 console for errors |
| DB connection fails | Verify MySQL is running |
| Messages not sending | Check ChatController.php path |
| Styling broken | Clear cache (Ctrl+Shift+Delete) |
| FAQ not loading | Check database connection |

---

## 📊 FEATURES

✨ **Interface**
- Modern gradient design
- Smooth animations
- Responsive layout
- Dark/Light themes ready

💬 **Chat**
- Real-time messaging
- Typing indicators
- Message history
- Session persistence

📚 **FAQ**
- 20+ pre-answered questions
- 5 organized categories
- Expandable interface
- Quick search

🗄️ **Backend**
- PHP-based
- MySQL database
- RESTful API
- Session management

---

## 📞 DEFAULT CONTACT INFO

**NCC Admissions:**
- 📞 Phone: (032) 268-8000
- 📧 Email: info@nccebu.edu.ph
- 📍 Address: Osmeña Blvd, Cebu City

---

## 🚀 DEPLOYMENT

### For Production:

1. **Use HTTPS**
   ```php
   // In ChatController.php, verify HTTPS
   ```

2. **Set Strong DB Password**
   ```php
   define('DB_PASS', 'your_strong_password');
   ```

3. **Enable Error Logging**
   ```php
   error_reporting(0);  // Hide errors from users
   error_log('error message');  // Log to file
   ```

4. **Configure Firewall**
   - Allow only needed ports
   - Restrict database access

---

## 📚 RESOURCES

- **Font Awesome Icons**: https://fontawesome.com
- **CSS Grid**: https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout
- **PHP Manual**: https://www.php.net/manual/
- **MySQL Manual**: https://dev.mysql.com/doc/

---

## ✅ CHECKLIST

- [ ] XAMPP installed and running
- [ ] Database created and populated
- [ ] Chatbot accessible at localhost/NCCchat
- [ ] Can send messages and receive responses
- [ ] FAQ sidebar opens and shows questions
- [ ] Mobile view looks correct
- [ ] All links work properly

---

**Last Updated**: April 2024  
**Version**: 1.0  
**Built for**: NCC (Northeastern Cebu Colleges)
