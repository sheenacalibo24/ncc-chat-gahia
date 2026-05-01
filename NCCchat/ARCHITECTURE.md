# NCC Chatbot - Architecture & Flow Diagrams

## 📋 System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER'S WEB BROWSER                           │
│                                                                  │
│  ┌────────────────────────────────────────────────────────┐    │
│  │              index.php (Chat Interface)                │    │
│  │  • HTML Structure                                      │    │
│  │  • Chat input field                                   │    │
│  │  • Message display area                               │    │
│  │  • FAQ sidebar                                        │    │
│  └────────────────────────────────────────────────────────┘    │
│                           ↓                                      │
│  ┌────────────────────────────────────────────────────────┐    │
│  │           views/layouts/main.js (Frontend)            │    │
│  │  • Handle message sending                             │    │
│  │  • Display messages                                   │    │
│  │  • Load FAQ                                           │    │
│  │  • Session management                                 │    │
│  └────────────────────────────────────────────────────────┘    │
│                           ↓                                      │
│  ┌────────────────────────────────────────────────────────┐    │
│  │         views/layouts/style.css (Styling)             │    │
│  │  • Beautiful gradient design                           │    │
│  │  • Responsive layout                                  │    │
│  │  • Smooth animations                                  │    │
│  └────────────────────────────────────────────────────────┘    │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
           ↕ (HTTP Request/Response)
┌─────────────────────────────────────────────────────────────────┐
│                    WEB SERVER (Apache)                          │
│                                                                  │
│  ┌────────────────────────────────────────────────────────┐    │
│  │    controllers/ChatController.php (API Handler)       │    │
│  │  • Process messages                                   │    │
│  │  • Generate responses                                 │    │
│  │  • Handle FAQ requests                                │    │
│  │  • Manage sessions                                    │    │
│  └────────────────────────────────────────────────────────┘    │
│                           ↓                                      │
│  ┌────────────────────────────────────────────────────────┐    │
│  │         models/Conversation.php (Data Layer)          │    │
│  │  • Save messages                                      │    │
│  │  • Retrieve messages                                  │    │
│  │  • Manage conversations                               │    │
│  └────────────────────────────────────────────────────────┘    │
│                           ↓                                      │
│  ┌────────────────────────────────────────────────────────┐    │
│  │          models/FAQ.php (Data Layer)                  │    │
│  │  • Search FAQ                                         │    │
│  │  • Get categories                                     │    │
│  │  • Retrieve answers                                   │    │
│  └────────────────────────────────────────────────────────┘    │
│                           ↓                                      │
│  ┌────────────────────────────────────────────────────────┐    │
│  │      config/db.php (Database Connection)              │    │
│  │  • Connect to MySQL                                   │    │
│  │  • Create tables                                      │    │
│  │  • Initialize data                                    │    │
│  └────────────────────────────────────────────────────────┘    │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
           ↕ (Database Queries)
┌─────────────────────────────────────────────────────────────────┐
│                    MySQL DATABASE                               │
│                                                                  │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐         │
│  │              │  │              │  │              │         │
│  │  conversations│  │   messages   │  │     faq      │         │
│  │              │  │              │  │              │         │
│  │ • id         │  │ • id         │  │ • id         │         │
│  │ • session_id │  │ • conv_id    │  │ • category   │         │
│  │ • user_name  │  │ • sender     │  │ • question   │         │
│  │ • email      │  │ • message    │  │ • answer     │         │
│  │ • timestamps │  │ • timestamp  │  │ • keywords   │         │
│  │              │  │              │  │              │         │
│  └──────────────┘  └──────────────┘  └──────────────┘         │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Message Flow

```
USER SENDS MESSAGE
       ↓
   ┌────────────────────────────────────┐
   │ main.js: sendMessage()             │
   │ • Collect message from input       │
   │ • Show typing indicator            │
   │ • Send to ChatController.php       │
   └────────────────────────────────────┘
       ↓
   ┌────────────────────────────────────┐
   │ ChatController.php: action='send'  │
   │ • Create/get conversation         │
   │ • Save user message in DB         │
   └────────────────────────────────────┘
       ↓
   ┌────────────────────────────────────┐
   │ FAQ.php: searchFAQ()               │
   │ • Search database for matches      │
   │ • Find similar questions           │
   │ • Return best matches              │
   └────────────────────────────────────┘
       ↓
   ┌────────────────────────────────────┐
   │ generateBotResponse()              │
   │ • Check for greetings              │
   │ • Use FAQ match if found           │
   │ • Generate intelligent response    │
   └────────────────────────────────────┘
       ↓
   ┌────────────────────────────────────┐
   │ Conversation.php: addMessage()     │
   │ • Save bot response in DB          │
   │ • Store timestamp                  │
   │ • Link to conversation             │
   └────────────────────────────────────┘
       ↓
   ┌────────────────────────────────────┐
   │ Return JSON Response               │
   │ {                                  │
   │   "status": "success",             │
   │   "bot_response": "Answer here"    │
   │ }                                  │
   └────────────────────────────────────┘
       ↓
   ┌────────────────────────────────────┐
   │ main.js: Display Response          │
   │ • Remove typing indicator          │
   │ • Display bot message              │
   │ • Add animation                    │
   │ • Auto-scroll to new message       │
   │ • Clear input field                │
   └────────────────────────────────────┘
       ↓
   CONVERSATION CONTINUES
```

---

## 📊 User Interface Layout

```
┌─────────────────────────────────────────────────────────┐
│                  CHATBOT HEADER                         │  
│  [🎓 NCC Chatbot] [Northeastern Cebu Colleges] [? ≡]  │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│            WELCOME BANNER                               │
│                                                          │
│  Welcome to NCC! 👋                                    │
│  Ask me anything about admissions, programs...         │
│                                                          │
│  [📖 About] [🎓 Programs] [💰 Tuition] [📞 Contact]   │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│           MESSAGES CONTAINER (Scrollable)               │
│                                                          │
│  [Bot] Hello! Welcome to NCC...                         │
│                                                          │
│                 [User] What programs? →                 │
│                                                          │
│  [Bot] NCC offers engineering, business...              │
│                                                          │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│            INPUT AREA                                    │
│                                                          │
│  [________________] [→]                                │
│  Type your question...                                  │
│                                                          │
│  💡 Powered by NCC AI Assistant | Available 24/7       │
└─────────────────────────────────────────────────────────┘

SIDEBAR (Open when FAQ button clicked):
┌──────────────────┐
│  FAQ             │
│  ✕               │
├──────────────────┤
│ ▪ Admissions     │
│ ▪ Finance        │
│ ▪ Campus Life    │
│ ▪ Academic       │
│ ▪ Contact        │
├──────────────────┤
│ ▶ Admission req? │
│                  │
│ ▶ What programs? │
│   Eng, Business..│
│                  │
│ ▶ Tuition fees?  │
│                  │
└──────────────────┘
```

---

## 🔐 Data Security Flow

```
USER INPUT
   ↓
INPUT VALIDATION (JavaScript)
   ↓
SANITIZATION (JavaScript)
   ↓
SEND TO SERVER
   ↓
SERVER INPUT VALIDATION (PHP)
   ↓
PREPARED STATEMENT QUERY
   ↓
PARAMETER BINDING (Prevents SQL Injection)
   ↓
DATABASE QUERY
   ↓
OUTPUT ESCAPING (Prevents XSS)
   ↓
JSON RESPONSE
   ↓
CLIENT JAVASCRIPT DISPLAY
   ↓
SAFE DISPLAY IN DOM
```

---

## 📱 Responsive Breakpoints

```
DESKTOP (1200px+)
┌─────────────────────────────────────────┐
│  Header with all buttons visible        │
│  Full-width chat interface              │
│  Welcome banner with 4 quick buttons    │
│  Messages side-by-side                  │
│  FAQ sidebar 380px wide                 │
└─────────────────────────────────────────┘

TABLET (768px-1200px)
┌──────────────────────────┐
│  Header adjusted         │
│  Chat interface 95%      │
│  Welcome banner 1 column │
│  Messages full width     │
│  FAQ sidebar full height │
└──────────────────────────┘

MOBILE (360px-768px)
┌──────────┐
│  Header  │
│ Compact  │
├──────────┤
│  Chat    │
│ 100%     │
│ width    │
├──────────┤
│ Input    │
│ Full     │
│ width    │
├──────────┤
│   FAQ    │
│  Drawer  │
│  from    │
│  right   │
└──────────┘
```

---

## 🗄️ Database Schema Diagram

```
conversations TABLE
┌──────────────────────────────────┐
│ id (PK)                          │
│ session_id (UNIQUE)              │ ──┐
│ user_name                        │  │
│ email                            │  │
│ created_at                       │  │
│ updated_at                       │  │
└──────────────────────────────────┘  │
                                      │
                  ┌───────────────────┘
                  │
                  │ (1 to Many)
                  │
                  ↓
messages TABLE
┌──────────────────────────────────┐
│ id (PK)                          │
│ conversation_id (FK) ────────────┤
│ sender                           │
│ message                          │
│ created_at                       │
└──────────────────────────────────┘


faq TABLE (Independent)
┌──────────────────────────────────┐
│ id (PK)                          │
│ category                         │
│ question                         │
│ answer                           │
│ keywords                         │
│ created_at                       │
│ updated_at                       │
└──────────────────────────────────┘
```

---

## 🔄 Session Management

```
FIRST VISIT
   ↓
Check localStorage for session_id
   ↓
NOT FOUND
   ↓
Generate new session_id: 'ncc_' + timestamp + random
   ↓
Store in localStorage
   ↓
Send with every request
   ↓
Server checks if conversation exists
   ↓
If NOT: Create new conversation
   ↓
If YES: Append to existing
   ↓
All messages linked to conversation
   ↓
NEXT VISIT
   ↓
localStorage session_id found
   ↓
Reuse same session
   ↓
All messages still in database
   ↓
User sees full conversation history
```

---

## 🎨 Color Theme

```
PRIMARY GRADIENT:
  Color 1: #667eea (Purple) → Used for main elements
  Color 2: #764ba2 (Dark Purple) → Used for depth
  
ACCENT COLORS:
  User Messages: Purple gradient
  Bot Messages: Light gray
  Hover States: Darker purple
  
BACKGROUND:
  Page: Purple gradient
  Chat: White
  Banner: Light gray
  
TEXT:
  Primary: #333 (dark gray)
  Secondary: #666 (medium gray)
  Light: #999 (light gray)
  Inverted: #fff (white for dark backgrounds)
```

---

## 🚀 Deployment Pipeline

```
LOCAL DEVELOPMENT
   ↓
Test on XAMPP
   ↓
Verify all features
   ↓
Check database
   ↓
Test on mobile
   ↓
All tests PASS
   ↓
PRODUCTION SERVER
   ↓
Copy files to server
   ↓
Configure database
   ↓
Enable HTTPS
   ↓
Set strong password
   ↓
Initialize database
   ↓
LIVE & RUNNING ✅
```

---

## 📈 Scalability

```
CURRENT (Single Server):
   User → Apache → PHP → MySQL

FUTURE (Scalable):
   Load Balancer
        ↓
   Apache Server 1 ──┐
   Apache Server 2 ──┼─→ MySQL Cluster
   Apache Server 3 ──┘

FUTURE (Advanced):
   CDN (CSS, JS, Fonts)
        ↓
   Load Balancer
        ↓
   [Multiple Servers]
        ↓
   [Database Cluster]
        ↓
   [Cache Layer - Redis]
```

---

## 📋 File Dependencies

```
index.php
    ├─ views/layouts/style.css
    ├─ views/layouts/main.js
    │   ├─ localStorage (browser)
    │   └─ Fetches from controllers/ChatController.php
    │       ├─ config/db.php
    │       ├─ models/Conversation.php
    │       └─ models/FAQ.php
    │           └─ MySQL Database
    └─ Font Awesome CDN (external)
```

---

## 🎯 Performance Optimization

```
FRONTEND:
  ✅ Minified CSS ready
  ✅ Minified JS ready
  ✅ External fonts (CDN)
  ✅ Efficient DOM updates
  ✅ Event delegation

BACKEND:
  ✅ Prepared statements
  ✅ Indexed queries
  ✅ Connection pooling
  ✅ Error handling
  ✅ Session caching

DATABASE:
  ✅ Proper indexing
  ✅ Foreign keys
  ✅ Query optimization
  ✅ Auto-incrementing IDs
```

---

**End of Architecture Documentation**
