# NCC Chatbot - Northeastern Cebu Colleges

A modern, interactive chatbot built for Northeastern Cebu Colleges (NCC) to provide students, parents, and visitors with information about admissions, programs, tuition, campus life, and general inquiries.

## Features

✨ **Modern UI/UX**
- Beautiful gradient design with smooth animations
- Responsive layout for desktop, tablet, and mobile
- Real-time message updates with typing indicators
- Professional color scheme (Purple & Blue gradient)

💬 **Intelligent Chatbot**
- FAQ-based response system
- Natural language processing for keyword matching
- Conversation history tracking
- Session management with unique IDs

🛠️ **Admin Panel** (NEW!)
- Add/Edit/Delete FAQs
- Manage FAQ categories
- View chat logs and conversations
- Analytics: Most asked questions
- Post announcements
- Session-based authentication

📚 **FAQ Management**
- Pre-populated with 20+ common questions
- Organized by 5 categories (Admissions, Finance, Academic, Campus Life, Contact)
- Easy expandable/collapsible interface
- Quick-access buttons for popular topics
- Admin-managed content

🗄️ **Database System**
- MySQL-based persistence
- Conversation history storage
- User session tracking
- FAQ database for easy content management
- Admin user management
- Analytics tracking

## Project Structure

```
NCCchat/
├── index.php                 # Main entry point
├── config/
│   └── db.php               # Database connection & initialization
├── models/
│   ├── Conversation.php     # Message & conversation management
│   └── FAQ.php              # FAQ data retrieval
├── controllers/
│   └── ChatController.php   # Request handling & routing
└── views/
    └── layouts/
        ├── style.css        # CSS styling
        └── main.js          # Frontend JavaScript
```

## Installation

### Requirements
- PHP 7.4+
- MySQL 5.7+
- Apache/XAMPP
- Modern web browser

### Setup Steps

1. **Extract files** to your XAMPP htdocs folder:
   ```
   C:\xampp\htdocs\NCCchat
   ```

2. **Start XAMPP Services**
   - Start Apache
   - Start MySQL

3. **Access the application**
   ```
   http://localhost/NCCchat
   ```

The application will automatically:
- Create the database (`ncc_chatbot`)
- Create necessary tables (conversations, messages, faq)
- Populate FAQ data

## Usage

### For Users

1. **Ask Questions**: Type your question in the input field and press Enter or click the send button
2. **Quick Access**: Use the quick buttons to ask about common topics
3. **Browse FAQ**: Click the FAQ icon to view frequently asked questions organized by category
4. **View History**: All messages are saved in your session

### Available Topics

- **Admissions** - Requirements, process, programs
- **Finance** - Tuition fees, scholarships, financial aid
- **Campus Life** - Facilities, activities, clubs
- **Academic** - Calendar, support services
- **Contact** - Phone, email, address information

### For Administrators

#### Adding/Updating FAQ

Connect to MySQL and update the FAQ table:

```sql
-- Add new FAQ
INSERT INTO faq (category, question, answer, keywords) 
VALUES ('Category', 'Your Question?', 'Your Answer', 'keywords');

-- Update existing FAQ
UPDATE faq SET answer = 'New Answer' WHERE id = 1;
```

#### Categories Available
- Admissions
- Finance
- Campus Life
- Academic
- Contact

## Database Schema

### conversations table
```
id (INT) - Primary Key
session_id (VARCHAR) - Unique session identifier
user_name (VARCHAR) - User name
email (VARCHAR) - User email
created_at (TIMESTAMP) - Creation time
updated_at (TIMESTAMP) - Last update time
```

### messages table
```
id (INT) - Primary Key
conversation_id (INT) - Foreign Key
sender (VARCHAR) - 'user' or 'bot'
message (TEXT) - Message content
created_at (TIMESTAMP) - Creation time
```

### faq table
```
id (INT) - Primary Key
category (VARCHAR) - FAQ category
question (TEXT) - Question text
answer (LONGTEXT) - Answer text
keywords (VARCHAR) - Search keywords
created_at (TIMESTAMP) - Creation time
updated_at (TIMESTAMP) - Last update time
```

## API Endpoints

### ChatController.php

**Send Message**
```
POST /controllers/ChatController.php
Parameters:
  - action: 'send_message'
  - session_id: unique session ID
  - message: user message
  - user_name: user name (optional)

Response: { status, bot_response, conversation_id }
```

**Get Messages**
```
POST /controllers/ChatController.php
Parameters:
  - action: 'get_messages'
  - conversation_id: conversation ID

Response: { status, messages[] }
```

**Search FAQ**
```
POST /controllers/ChatController.php
Parameters:
  - action: 'search_faq'
  - query: search query

Response: { status, results[] }
```

**Get Categories**
```
GET /controllers/ChatController.php?action=get_categories
Response: { status, categories[] }
```

**Get FAQ by Category**
```
GET /controllers/ChatController.php?action=get_faq&category=Admissions
Response: { status, faqs[] }
```

## Features in Detail

### Smart Response System
- Detects greetings and responds appropriately
- Searches FAQ database for relevant answers
- Provides fallback responses with contact information
- Tracks conversation context

### Session Management
- Unique session ID per browser
- Persistent conversation history
- Session data stored in browser localStorage
- Automatic session creation

### Modern Design
- CSS Grid & Flexbox layout
- Smooth animations and transitions
- Gradient backgrounds
- Icon integration (Font Awesome)
- Mobile-first responsive design

### Real-time Features
- Instant message delivery
- Typing indicators
- Live FAQ browsing
- Auto-scrolling message container

## Customization

### Change School Information

Edit `config/db.php` and update the FAQ data:

```php
$faqs = [
    ["Category", "Question?", "Answer text here", "keywords"],
    // Add more FAQs
];
```

### Modify Colors

Edit `views/layouts/style.css` and update the gradient colors:

```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Add New Features

1. Create new controllers in `controllers/`
2. Create models in `models/`
3. Update JavaScript in `views/layouts/main.js`

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running
- Check credentials in `config/db.php`
- Verify database user exists

### Messages Not Sending
- Check browser console for errors
- Verify ChatController.php path
- Ensure PHP is enabled

### FAQ Not Loading
- Verify FAQ data was inserted into database
- Check database connection
- Clear browser cache

### Styling Issues
- Clear browser cache (Ctrl+Shift+Delete)
- Hard refresh (Ctrl+F5)
- Check if CSS file is loading (F12 > Network)

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Security Notes

- Input validation is performed server-side
- SQL prepared statements prevent injection
- Session IDs are cryptographically unique
- HTTPS recommended for production

## Performance

- Lightweight CSS framework
- Minimal JavaScript dependencies
- Efficient database queries with indexing
- Optimized image loading (Font Awesome CDN)

## Future Enhancements

- AI/ML-based response system
- Multi-language support
- Voice input/output
- Analytics dashboard
- Admin panel for FAQ management
- Email integration
- Scheduling & appointment system
- Integration with school calendar

## Support & Contact

For support or inquiries:
- Email: info@nccebu.edu.ph
- Phone: (032) 268-8000
- Address: Osmeña Blvd, Cebu City

## License

This project is proprietary to Northeastern Cebu Colleges.

---

**Version**: 1.0  
**Last Updated**: 2024  
**Built with**: PHP, HTML, CSS, JavaScript, MySQL
