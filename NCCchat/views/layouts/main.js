// Session Management
const SESSION_ID = localStorage.getItem('ncc_session_id') || generateSessionId();
let conversationId = null;
let isLoading = false;

if (!localStorage.getItem('ncc_session_id')) {
    localStorage.setItem('ncc_session_id', SESSION_ID);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeChatbot();
});

function initializeChatbot() {
    loadFAQCategories();
    attachEventListeners();
    showWelcomeMessage();
}

function attachEventListeners() {
    const faqBtn = document.getElementById('faq-btn');
    const sendBtn = document.getElementById('send-btn');
    
    if (faqBtn) faqBtn.addEventListener('click', openFAQ);
    if (sendBtn) sendBtn.addEventListener('click', sendMessage);
}

// Generate unique session ID
function generateSessionId() {
    return 'ncc_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
}

// Display welcome message
function showWelcomeMessage() {
    const container = document.getElementById('messages-container');
    if (container && container.children.length === 0) {
        const welcomeMsg = document.createElement('div');
        welcomeMsg.className = 'message bot';
        welcomeMsg.innerHTML = `
            <div>
                <div class="message-bubble">
                    👋 Welcome to NCC Chatbot! I'm here to help you with any questions about Northeastern Cebu Colleges. 
                    Ask me about admissions, programs, tuition, campus facilities, or anything else about NCC!
                </div>
                <div class="message-time">${formatTime(new Date())}</div>
            </div>
        `;
        container.appendChild(welcomeMsg);
    }
}

// Send message
function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    
    if (!message || isLoading) return;
    
    isLoading = true;
    const sendBtn = document.getElementById('send-btn');
    sendBtn.disabled = true;
    
    // Add user message to UI
    addMessageToUI('user', message);
    input.value = '';
    
    // Show typing indicator
    showTypingIndicator();
    
    // Get user name from session
    const userName = localStorage.getItem('ncc_user_name') || 'Guest';
    
    // Send to backend
    const formData = new FormData();
    formData.append('action', 'send_message');
    formData.append('session_id', SESSION_ID);
    formData.append('message', message);
    formData.append('user_name', userName);
    
    fetch('controllers/ChatController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        removeTypingIndicator();
        
        if (data.status === 'success') {
            conversationId = data.conversation_id;
            addMessageToUI('bot', data.bot_response);
        } else {
            addMessageToUI('bot', 'Sorry, there was an error processing your request. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        removeTypingIndicator();
        addMessageToUI('bot', 'Sorry, I encountered an error. Please try again later.');
    })
    .finally(() => {
        isLoading = false;
        sendBtn.disabled = false;
        input.focus();
    });
}

// Add message to UI
function addMessageToUI(sender, message) {
    const container = document.getElementById('messages-container');
    const messageEl = document.createElement('div');
    messageEl.className = `message ${sender}`;
    
    const bubble = document.createElement('div');
    bubble.className = 'message-bubble';
    bubble.textContent = message;
    
    const time = document.createElement('div');
    time.className = 'message-time';
    time.textContent = formatTime(new Date());
    
    messageEl.appendChild(bubble);
    messageEl.appendChild(time);
    
    container.appendChild(messageEl);
    container.scrollTop = container.scrollHeight;
}

// Show typing indicator
function showTypingIndicator() {
    const container = document.getElementById('messages-container');
    const typingEl = document.createElement('div');
    typingEl.className = 'message bot';
    typingEl.id = 'typing-indicator';
    typingEl.innerHTML = `
        <div class="message-bubble">
            <div class="typing-indicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>
    `;
    container.appendChild(typingEl);
    container.scrollTop = container.scrollHeight;
}

// Remove typing indicator
function removeTypingIndicator() {
    const typingEl = document.getElementById('typing-indicator');
    if (typingEl) typingEl.remove();
}

// Handle keyboard enter
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
}

// Quick question
function quickQuestion(question) {
    const input = document.getElementById('message-input');
    input.value = question;
    sendMessage();
}

// Format time
function formatTime(date) {
    return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}

// FAQ Functions
function openFAQ() {
    const sidebar = document.getElementById('faq-sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.add('active');
    overlay.classList.add('active');
}

function closeFAQ() {
    const sidebar = document.getElementById('faq-sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
}

// Load FAQ categories
function loadFAQCategories() {
    fetch('controllers/ChatController.php?action=get_categories')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                displayCategories(data.categories);
            }
        })
        .catch(error => console.error('Error loading categories:', error));
}

// Display FAQ categories
function displayCategories(categories) {
    const container = document.getElementById('faq-categories');
    container.innerHTML = '';
    
    categories.forEach(category => {
        const btn = document.createElement('button');
        btn.className = 'faq-cat-btn';
        btn.textContent = category;
        btn.addEventListener('click', () => loadFAQByCategory(category, btn));
        container.appendChild(btn);
    });
}

// Load FAQ by category
function loadFAQByCategory(category, btn) {
    // Update active state
    document.querySelectorAll('.faq-cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    const formData = new FormData();
    formData.append('action', 'get_faq');
    formData.append('category', category);
    
    fetch('controllers/ChatController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayFAQItems(data.faqs);
        }
    })
    .catch(error => console.error('Error loading FAQ:', error));
}

// Display FAQ items
function displayFAQItems(faqs) {
    const container = document.getElementById('faq-content');
    container.innerHTML = '';
    
    faqs.forEach(faq => {
        const item = document.createElement('div');
        item.className = 'faq-item';
        item.innerHTML = `
            <div class="faq-question" onclick="toggleFAQAnswer(this)">
                <i class="fas fa-chevron-right" style="margin-right: 8px;"></i>
                ${faq.question}
            </div>
            <div class="faq-answer">
                ${faq.answer.replace(/\n/g, '<br>')}
            </div>
        `;
        container.appendChild(item);
    });
}

// Toggle FAQ answer
function toggleFAQAnswer(questionEl) {
    const answerEl = questionEl.nextElementSibling;
    answerEl.classList.toggle('show');
    
    // Rotate icon
    const icon = questionEl.querySelector('i');
    if (answerEl.classList.contains('show')) {
        icon.style.transform = 'rotate(90deg)';
    } else {
        icon.style.transform = 'rotate(0)';
    }
}

// Fetch using GET
function fetchFAQByCategory(category) {
    fetch(`controllers/ChatController.php?action=get_faq&category=${encodeURIComponent(category)}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                displayFAQItems(data.faqs);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Admin login function
function goToAdmin() {
    window.location.href = './admin.php';
}
