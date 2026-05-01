## NCC CHATBOT - QUICK START GUIDE

### What Has Been Created:

✅ **Modern Chatbot Interface**
   - Beautiful purple gradient design
   - Responsive for desktop, tablet & mobile
   - Real-time chat with animations
   - FAQ sidebar with categories

✅ **Complete Backend System**
   - PHP-based chat controller
   - MySQL database with 3 tables
   - Conversation history tracking
   - Smart FAQ search system

✅ **Database Ready**
   - Pre-populated with 20+ FAQ entries
   - 5 FAQ categories (Admissions, Finance, Academic, Campus Life, Contact)
   - Automatic table creation on first load
   - Session management

✅ **Files Created**
   - index.php - Main entry point
   - config/db.php - Database connection & setup
   - models/Conversation.php - Message management
   - models/FAQ.php - FAQ retrieval
   - controllers/ChatController.php - Request handling
   - views/layouts/style.css - Modern styling
   - views/layouts/main.js - Frontend logic
   - README.md - Full documentation

---

### SETUP INSTRUCTIONS:

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache
   - Start MySQL

2. **Access the Chatbot**
   - Open browser: http://localhost/NCCchat
   - If you see a blank page, check browser console (F12)

3. **Initial Database Setup**
   - On first load, database is created automatically
   - FAQ data is populated automatically
   - No manual setup needed!

---

### FEATURES:

💬 **Chat Features**
   - Send questions, get instant AI-powered responses
   - Quick access buttons for popular topics
   - Full conversation history
   - Typing indicators

📚 **FAQ Sidebar**
   - Browse 20+ pre-answered questions
   - Organized in 5 categories
   - Click to expand/collapse answers
   - Search functionality

🎨 **Modern Design**
   - Purple & Blue gradient theme
   - Smooth animations
   - Mobile-friendly interface
   - Professional appearance

---

### DATABASE LOCATION:
- Database Name: ncc_chatbot
- Location: Your MySQL installation
- Created automatically on first visit

### CUSTOMIZATION:

**Change School Contact Info:**
Edit config/db.php and update the FAQ entries

**Change Colors:**
Edit views/layouts/style.css lines 13-14 and other gradient references

**Add More Questions:**
Insert into FAQ table via MySQL:
```sql
INSERT INTO faq (category, question, answer, keywords) 
VALUES ('Category', 'Question?', 'Answer text', 'keywords');
```

---

### DEFAULT FAQ CATEGORIES:
- Admissions (3 questions)
- Finance (2 questions)
- Campus Life (2 questions)
- Academic (2 questions)
- Contact (1 question)

---

### TROUBLESHOOTING:

❌ "Blank white page"
→ Check browser console (F12) for errors
→ Ensure MySQL is running
→ Check if Apache is serving the file

❌ "Database connection error"
→ Verify MySQL is running
→ Check config/db.php credentials
→ Look at browser console (F12) → Network tab

❌ "Messages not sending"
→ Open F12 console and check for error messages
→ Verify ChatController.php is in controllers folder
→ Check PHP error logs in XAMPP

❌ "Styling looks broken"
→ Press Ctrl+Shift+Delete to clear cache
→ Hard refresh: Ctrl+F5
→ Check if style.css file exists

---

### NEXT STEPS:

1. ✅ Access: http://localhost/NCCchat
2. ✅ Try asking questions about NCC
3. ✅ Click FAQ button to browse questions
4. ✅ Check the database for stored conversations

### SUPPORT:

- Complete README.md documentation included
- API endpoints documented
- Database schema explained
- Troubleshooting guide available

---

**Everything is ready to go! Just start XAMPP and open the link above! 🎉**
