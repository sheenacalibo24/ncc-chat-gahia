# 🛠️ NCC ADMIN PANEL - COMPLETE GUIDE

## 📋 Overview

The NCC Admin Panel is a complete management system for the school chatbot. Administrators can manage FAQs, view chat logs, track analytics, and post announcements.

---

## 🚀 Quick Access

**URL**: `http://localhost/NCCchat/admin.php`

**Default Credentials**:
- Username: `admin`
- Password: `ncc123456`

**First Login Steps**:
1. Visit admin.php
2. Enter username and password
3. Click "Login"
4. Dashboard loads with all features

---

## 🔐 Authentication

### Login System
- Session-based authentication
- Passwords encrypted with bcrypt
- Admin users stored in database
- Session timeout for security

### User Roles
- **Admin**: Full access to all features
- (Extensible for multiple roles)

---

## 📊 Admin Features

### 1️⃣ DASHBOARD

**What You See**:
- Total Conversations count
- Total Messages sent
- Total FAQs available
- Today's Chat Count

**Use Case**: Quick overview of system activity

**Automatic Updates**: Refreshes on each page load

---

### 2️⃣ FAQ MANAGEMENT

**Features**:
- ✅ Add new FAQs
- ✅ Edit existing FAQs
- ✅ Delete FAQs
- ✅ View all FAQs
- ✅ Search by category

**How to Add FAQ**:
1. Click "Add FAQ" button
2. Select Category (or create new)
3. Enter Question
4. Enter Answer
5. Add Keywords (optional)
6. Click "Save FAQ"

**How to Edit FAQ**:
1. Find FAQ in list
2. Click "Edit" button
3. Modify any field
4. Click "Save FAQ"

**How to Delete FAQ**:
1. Find FAQ in list
2. Click "Delete" button
3. Confirm deletion

**FAQ Categories** (Pre-configured):
- Admissions
- Finance
- Campus Life
- Academic
- Contact

**Best Practices**:
- Use clear, concise questions
- Write detailed answers
- Add relevant keywords for search
- Keep FAQs updated regularly

---

### 3️⃣ CATEGORIES MANAGEMENT

**What You Can Do**:
- View all existing categories
- Create new categories (when adding FAQs)
- Organize FAQs by category

**Default Categories**:
```
Admissions
Finance
Campus Life
Academic
Contact
```

**How to Add Category**:
1. Go to Categories section
2. When creating new FAQ, select "+ Add New Category"
3. Type category name
4. Save with FAQ

---

### 4️⃣ CHAT LOGS

**What You See**:
- User Name
- Email Address
- Number of Messages
- Date of Conversation
- View Full Conversation

**How to View Chat**:
1. Go to Chat Logs section
2. Browse the table
3. Click "View" to see all messages
4. See message exchange between user and bot

**Tracked Information**:
- User details
- All messages exchanged
- Message timestamps
- Session information

**Use Cases**:
- Customer support follow-up
- Understand user needs
- Improve FAQ based on questions

---

### 5️⃣ ANALYTICS

**Most Asked Questions**:
- See top 10 frequently asked questions
- Times each question was asked
- Last time question was asked

**Metrics Tracked**:
- Question asked
- Number of times asked
- Last ask timestamp

**How to Use Analytics**:
1. Go to Analytics section
2. View most frequently asked questions
3. Use this to identify common needs
4. Update FAQs to address top questions
5. Improve chatbot response quality

**Benefits**:
- Identify knowledge gaps
- Improve FAQ relevance
- Track user interests
- Optimize content

---

### 6️⃣ ANNOUNCEMENTS

**Features**:
- ✅ Create announcements
- ✅ Edit announcements
- ✅ Delete announcements
- ✅ Activate/Deactivate
- ✅ Track creator & date

**How to Create Announcement**:
1. Click "Add Announcement" button
2. Enter Title
3. Enter Content (can include HTML)
4. Click "Save Announcement"

**How to Edit Announcement**:
1. Find announcement in list
2. Click "Edit" button
3. Modify title/content
4. Click "Save Announcement"

**How to Deactivate Announcement**:
1. Find announcement in list
2. Click "Deactivate" button
3. Announcement hidden from chatbot

**How to Delete Announcement**:
1. Find announcement in list
2. Click "Delete" button
3. Confirm deletion

**Use Cases for Announcements**:
- Important notices
- Schedule announcements
- System maintenance info
- Holiday notices
- Event promotions

---

## 🗄️ Database Tables

### admin_users
```
id - Primary Key
username - Login username
password - Encrypted password
email - Admin email
role - User role (admin, etc.)
is_active - Account status
created_at - Account creation date
updated_at - Last update date
```

### faq
```
id - Primary Key
category - FAQ category
question - Question text
answer - Answer text
keywords - Search keywords
created_at - Creation date
updated_at - Update date
```

### announcements
```
id - Primary Key
title - Announcement title
content - Announcement content
is_active - Visibility status
created_by - Admin who created it
created_at - Creation date
updated_at - Update date
```

### chat_analytics
```
id - Primary Key
question - User question
ask_count - Number of times asked
last_asked - Last time asked
```

---

## 🔄 Admin Workflow

### Daily Tasks
1. Check Dashboard for activity
2. Review Chat Logs for issues
3. Check Analytics for new questions
4. Update FAQs if needed
5. Post any announcements

### Weekly Tasks
1. Review most asked questions
2. Update FAQ content
3. Identify knowledge gaps
4. Plan new categories if needed

### Monthly Tasks
1. Review overall statistics
2. Plan content updates
3. Analyze user patterns
4. Improve response quality

---

## 📱 Responsive Admin Panel

**Adapts to Screen Size**:
- Desktop: Full sidebar navigation
- Tablet: Compact sidebar (icons only)
- Mobile: Touch-friendly buttons
- Responsive tables with scrolling

---

## 🔒 Security Features

- ✅ Session-based authentication
- ✅ Password encryption (bcrypt)
- ✅ SQL injection prevention
- ✅ Input validation
- ✅ Session timeout
- ✅ Admin access logging (optional)

---

## 🛠️ API Endpoints

### Authentication
```
POST /controllers/AdminController.php
action: login
username: admin
password: ncc123456
```

### FAQ Operations
```
POST /controllers/AdminController.php
action: add_faq / update_faq / delete_faq / get_all_faqs / get_faq
```

### Chat Logs
```
POST /controllers/AdminController.php
action: get_chat_logs / get_conversation
limit: 50
offset: 0
```

### Analytics
```
POST /controllers/AdminController.php
action: get_most_asked / get_stats
```

### Announcements
```
POST /controllers/AdminController.php
action: add_announcement / update_announcement / delete_announcement
       / get_announcements / toggle_announcement
```

---

## 📊 Management Features Details

### FAQ Management
- **Add/Edit/Delete**: Full CRUD operations
- **Bulk Operations**: (Can be added)
- **Search**: By category
- **Sort**: By category, date
- **Preview**: Answer preview in table

### Chat Analysis
- **View Logs**: See all conversations
- **Search**: By user name, email
- **Export**: (Can be added)
- **Filter**: By date range (can be added)
- **Pagination**: Load more logs

### Analytics Insights
- **Top Questions**: Most frequently asked
- **Trends**: Question frequency over time
- **Search Terms**: Keywords users search for
- **User Patterns**: Common inquiry types
- **Feedback**: Identify gaps in FAQ

### Announcement Broadcasting
- **Create/Update**: Easy content management
- **Publish**: Immediate visibility
- **Schedule**: (Can be added)
- **Target**: All users (can filter by role)
- **Expire**: Set expiration dates (can be added)

---

## 🎨 Admin Panel UI

### Dashboard
- 4 stat cards showing key metrics
- Real-time updates
- Color-coded values

### Navigation
- Sidebar with 6 main sections
- Active state highlighting
- Easy section switching
- Responsive menu

### Tables
- Sortable columns (can be added)
- Action buttons
- Responsive scrolling
- Clean formatting

### Forms
- Modal dialogs
- Input validation
- Error messages
- Success feedback

---

## 🚀 Advanced Features

### Available (Built-in)
- Login authentication
- Session management
- FAQ CRUD operations
- Chat log viewing
- Analytics tracking
- Announcement management
- Responsive design

### Can Be Added
- User roles (editor, viewer)
- Bulk FAQ import/export
- Email notifications
- Advanced analytics
- Report generation
- API key management
- Audit logging
- Performance metrics

---

## 🔄 Data Flow

```
Admin Login
    ↓
Session Created
    ↓
Dashboard Loads
    ↓
Select Feature
    ↓
Load Feature Data
    ↓
Display Interface
    ↓
Make Changes
    ↓
Send to API
    ↓
Database Updates
    ↓
Confirmation Message
    ↓
Refresh Display
```

---

## 📈 Analytics Examples

### Most Asked Questions Report
```
Question                          | Times Asked | Last Asked
What is tuition?                  | 125        | Today 2:30 PM
Admission requirements?           | 98         | Today 1:45 PM
Campus facilities?                | 87         | Yesterday 4:20 PM
How to contact?                   | 65         | Today 3:15 PM
Academic calendar?                | 52         | 2 days ago
```

### Daily Activity Summary
```
Total Conversations:    45
Total Messages:         320
Average Messages/Chat:  7.1
Today's New Chats:      12
```

---

## ✅ Admin Panel Checklist

- ✅ Login system working
- ✅ Dashboard displaying stats
- ✅ FAQ management functional
- ✅ Categories organized
- ✅ Chat logs viewable
- ✅ Analytics showing data
- ✅ Announcements working
- ✅ Session management secure
- ✅ Responsive design
- ✅ Error handling complete

---

## 🔗 File References

**Main Admin File**: `admin.php`
**API Controller**: `controllers/AdminController.php`
**Admin Model**: `models/Admin.php`
**Frontend Logic**: `views/layouts/admin.js`
**Database Config**: `config/db.php`

---

## 🎓 Administrator Tips

1. **Regular Updates**: Keep FAQs current
2. **Monitor Analytics**: Update based on top questions
3. **Post Announcements**: Keep students informed
4. **Review Logs**: Understand user needs
5. **Organize Categories**: Logical grouping
6. **Use Keywords**: Better search results
7. **Clear Answers**: Easy to understand
8. **Backup Data**: Regular database backups

---

## 🆘 Troubleshooting

**Can't Login**
- Check username/password
- Ensure admin account exists
- Clear browser cookies
- Try different browser

**Can't Save FAQ**
- Check all required fields filled
- Verify category selected
- Check database connection
- Review browser console for errors

**Analytics Not Showing**
- Check if conversations exist
- Allow time for data to accumulate
- Refresh the page
- Check database connection

**Announcements Not Appearing**
- Verify is_active = 1
- Check announcement creation date
- Verify user permission
- Clear cache

---

## 📞 Support

For admin panel issues:
1. Check error messages in browser console (F12)
2. Verify database connection
3. Check file permissions
4. Review AdminController.php logs
5. Consult README.md for general help

---

**Admin Panel Version**: 1.0  
**Last Updated**: April 2024  
**For**: NCC (Northeastern Cebu Colleges)

---

Ready to manage your NCC Chatbot! 🎉
