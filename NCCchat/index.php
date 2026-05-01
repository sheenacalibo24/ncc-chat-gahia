<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCC Chatbot - Northeastern Cebu Colleges</title>
    <link rel="stylesheet" href="views/layouts/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="chatbot-container">
        <!-- Header -->
        <div class="chatbot-header">
            <div class="header-left">
                <i class="fas fa-graduation-cap"></i>
                <div class="header-info">
                    <h1>NCC Chatbot</h1>
                    <p>Northeastern Cebu Colleges</p>
                </div>
            </div>
            <div class="header-right">
                <button id="faq-btn" class="header-btn" title="FAQ">
                    <i class="fas fa-question-circle"></i>
                </button>
                <button id="admin-btn" class="header-btn" title="Admin Login" onclick="goToAdmin()">
                    <i class="fas fa-lock"></i>
                </button>
                <button id="menu-btn" class="header-btn" title="Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h2>Welcome to NCC! 👋</h2>
            <p>Ask me anything about admissions, programs, fees, campus life, and more.</p>
            <div class="quick-buttons">
                <button class="quick-btn" onclick="quickQuestion('Tell me about NCC')">
                    <i class="fas fa-book"></i> About NCC
                </button>
                <button class="quick-btn" onclick="quickQuestion('What programs are available')">
                    <i class="fas fa-graduation-cap"></i> Programs
                </button>
                <button class="quick-btn" onclick="quickQuestion('How much is tuition')">
                    <i class="fas fa-money-bill-wave"></i> Tuition
                </button>
                <button class="quick-btn" onclick="quickQuestion('Contact information')">
                    <i class="fas fa-phone"></i> Contact
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="messages-container" class="messages-container">
            <!-- Messages will appear here -->
        </div>

        <!-- Input Area -->
        <div class="input-area">
            <div class="input-wrapper">
                <input 
                    type="text" 
                    id="message-input" 
                    class="message-input" 
                    placeholder="Type your question here..."
                    onkeypress="handleKeyPress(event)"
                >
                <button id="send-btn" class="send-btn" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <p class="disclaimer">💡 Powered by NCC AI Assistant | Available 24/7</p>
        </div>
    </div>

    <!-- FAQ Sidebar -->
    <div id="faq-sidebar" class="faq-sidebar">
        <div class="faq-header">
            <h3>Frequently Asked Questions</h3>
            <button class="close-btn" onclick="closeFAQ()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="faq-categories" class="faq-categories">
            <!-- Categories will load here -->
        </div>
        <div id="faq-content" class="faq-content">
            <!-- FAQ content will load here -->
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay" onclick="closeFAQ()"></div>

    <script src="views/layouts/main.js"></script>
</body>
</html>