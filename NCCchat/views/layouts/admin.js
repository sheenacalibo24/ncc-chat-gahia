// Admin Panel JavaScript

let currentAdminId = null;
let currentAdminUsername = null;

// Helper function to get the correct API path
function getAdminAPIPath() {
    return './controllers/AdminController.php';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    checkAdminStatus();
    setupEventListeners();
});

function checkAdminStatus() {
    // Check if already logged in (via session)
    const loginPage = document.getElementById('loginPage');
    const adminPanel = document.getElementById('adminPanel');
    
    // Check with server if user is logged in
    const formData = new FormData();
    formData.append('action', 'check_status');
    
    fetch('./controllers/AdminController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error, status = ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.logged_in) {
            currentAdminUsername = data.username;
            loginPage.style.display = 'none';
            adminPanel.classList.add('show');
            loadDashboard();
        } else {
            loginPage.style.display = 'flex';
            adminPanel.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Status check error:', error);
        loginPage.style.display = 'flex';
        adminPanel.style.display = 'none';
    });
}

function setupEventListeners() {
    // Login form
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        loginAdmin();
    });
    
    // FAQ form
    document.getElementById('faqForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveFAQ();
    });
    
    // Announcement form
    document.getElementById('announcementForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveAnnouncement();
    });
}

// ============ LOGIN ============

function loginAdmin() {
    const username = document.getElementById('loginUsername').value;
    const password = document.getElementById('loginPassword').value;
    
    if (!username || !password) {
        showLoginError('Please enter username and password');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'login');
    formData.append('username', username);
    formData.append('password', password);
    
    // Show loading state
    const loginBtn = document.querySelector('#loginForm button[type="submit"]');
    const originalText = loginBtn.textContent;
    loginBtn.disabled = true;
    loginBtn.textContent = 'Logging in...';
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network error: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        loginBtn.disabled = false;
        loginBtn.textContent = originalText;
        
        if (data.status === 'success') {
            currentAdminUsername = data.username || username;
            showAdminPanel();
            loadDashboard();
        } else {
            showLoginError(data.message || 'Login failed');
        }
    })
    .catch(error => {
        loginBtn.disabled = false;
        loginBtn.textContent = originalText;
        console.error('Login error:', error);
        showLoginError('Connection error: ' + error.message);
    });
}

function showLoginError(message) {
    const errorDiv = document.getElementById('loginError');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    setTimeout(() => {
        errorDiv.style.display = 'none';
    }, 5000);
}

function showError(message) {
    console.error('Admin Error:', message);
    alert('Error: ' + message);
}

function showAdminPanel() {
    document.getElementById('loginPage').style.display = 'none';
    document.getElementById('adminPanel').classList.add('show');
}

// ============ NAVIGATION ============

function switchSection(sectionName, element) {
    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.classList.remove('active'));
    
    // Remove active from all sidebar links
    const links = document.querySelectorAll('.admin-sidebar a');
    links.forEach(link => link.classList.remove('active'));
    
    // Show selected section
    const selectedSection = document.getElementById(sectionName + 'Section');
    if (selectedSection) {
        selectedSection.classList.add('active');
    }
    
    // Update title
    const titles = {
        dashboard: '📊 Dashboard',
        faqs: '📚 Manage FAQs',
        categories: '📂 Manage Categories',
        logs: '💬 Chat Logs',
        analytics: '📈 Most Asked Questions',
        announcements: '📢 Announcements'
    };
    
    document.getElementById('sectionTitle').textContent = titles[sectionName] || sectionName;
    
    // Mark sidebar link as active
    if (element) {
        element.classList.add('active');
    }
    
    // Load data based on section
    switch(sectionName) {
        case 'dashboard':
            loadDashboard();
            break;
        case 'faqs':
            loadFAQs();
            break;
        case 'categories':
            loadCategories();
            break;
        case 'logs':
            loadChatLogs();
            break;
        case 'analytics':
            loadAnalytics();
            break;
        case 'announcements':
            loadAnnouncements();
            break;
    }
}

// ============ DASHBOARD ============

function loadDashboard() {
    const formData = new FormData();
    formData.append('action', 'get_stats');
    
    console.log('Loading dashboard stats...');
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Dashboard data:', data);
        if (data.status === 'success') {
            // Update stats if elements exist
            const statConv = document.getElementById('statConversations');
            const statMsg = document.getElementById('statMessages');
            const statFAQ = document.getElementById('statFAQs');
            const statToday = document.getElementById('statToday');
            
            if (statConv) statConv.textContent = data.stats.total_conversations || 0;
            if (statMsg) statMsg.textContent = data.stats.total_messages || 0;
            if (statFAQ) statFAQ.textContent = data.stats.total_faqs || 0;
            if (statToday) statToday.textContent = data.stats.today_conversations || 0;
            
            console.log('Dashboard stats loaded successfully');
        } else {
            console.error('Dashboard error:', data.message);
        }
    })
    .catch(error => {
        console.error('Dashboard fetch error:', error);
        // Show error to user
        showError('Failed to load dashboard: ' + error.message);
    });
}

// ============ FAQs MANAGEMENT ============

function loadFAQs() {
    const formData = new FormData();
    formData.append('action', 'get_all_faqs');
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayFAQsTable(data.faqs);
            loadCategoriesForSelect();
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayFAQsTable(faqs) {
    let html = `
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    faqs.forEach(faq => {
        const answerPreview = faq.answer.substring(0, 50) + (faq.answer.length > 50 ? '...' : '');
        html += `
            <tr>
                <td>${faq.category}</td>
                <td>${faq.question}</td>
                <td>${answerPreview}</td>
                <td>
                    <button class="btn btn-primary" onclick="editFAQ(${faq.id})">Edit</button>
                    <button class="btn btn-danger" onclick="deleteFAQ(${faq.id})">Delete</button>
                </td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
    `;
    
    document.getElementById('faqsTable').innerHTML = html;
}

function loadCategoriesForSelect() {
    const formData = new FormData();
    formData.append('action', 'get_categories');
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const select = document.getElementById('faqCategory');
            select.innerHTML = '';
            
            data.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category;
                select.appendChild(option);
            });
            
            // Add option for new category
            const newOption = document.createElement('option');
            newOption.value = '';
            newOption.textContent = '+ Add New Category';
            select.appendChild(newOption);
        }
    })
    .catch(error => console.error('Error:', error));
}

function showFAQModal() {
    document.getElementById('faqId').value = '';
    document.getElementById('faqQuestion').value = '';
    document.getElementById('faqAnswer').value = '';
    document.getElementById('faqKeywords').value = '';
    document.getElementById('faqModalTitle').textContent = 'Add FAQ';
    document.getElementById('faqModal').classList.add('show');
}

function closeFAQModal() {
    document.getElementById('faqModal').classList.remove('show');
}

function editFAQ(id) {
    const formData = new FormData();
    formData.append('action', 'get_faq');
    formData.append('id', id);
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' && data.faq) {
            document.getElementById('faqId').value = data.faq.id;
            document.getElementById('faqCategory').value = data.faq.category;
            document.getElementById('faqQuestion').value = data.faq.question;
            document.getElementById('faqAnswer').value = data.faq.answer;
            document.getElementById('faqKeywords').value = data.faq.keywords;
            document.getElementById('faqModalTitle').textContent = 'Edit FAQ';
            document.getElementById('faqModal').classList.add('show');
        }
    })
    .catch(error => console.error('Error:', error));
}

function saveFAQ() {
    const id = document.getElementById('faqId').value;
    const category = document.getElementById('faqCategory').value;
    const question = document.getElementById('faqQuestion').value;
    const answer = document.getElementById('faqAnswer').value;
    const keywords = document.getElementById('faqKeywords').value;
    
    const formData = new FormData();
    formData.append('category', category);
    formData.append('question', question);
    formData.append('answer', answer);
    formData.append('keywords', keywords);
    
    if (id) {
        formData.append('action', 'update_faq');
        formData.append('id', id);
    } else {
        formData.append('action', 'add_faq');
    }
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            closeFAQModal();
            loadFAQs();
            showAlert(data.message, 'success');
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => showAlert('Error saving FAQ', 'error'));
}

function deleteFAQ(id) {
    if (!confirm('Are you sure you want to delete this FAQ?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_faq');
    formData.append('id', id);
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadFAQs();
            showAlert('FAQ deleted successfully', 'success');
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => showAlert('Error deleting FAQ', 'error'));
}

// ============ CATEGORIES MANAGEMENT ============

function loadCategories() {
    const formData = new FormData();
    formData.append('action', 'get_categories');
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayCategories(data.categories);
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayCategories(categories) {
    let html = `
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
    `;
    
    categories.forEach(category => {
        html += `
            <div style="background: #f5f7fa; padding: 15px; border-radius: 5px; text-align: center;">
                <h4>${category}</h4>
                <p style="font-size: 12px; color: #666; margin-top: 10px;">
                    Click to view FAQs in this category
                </p>
            </div>
        `;
    });
    
    html += `</div>`;
    document.getElementById('categoriesList').innerHTML = html;
}

function addCategory() {
    const categoryName = document.getElementById('newCategory').value;
    if (!categoryName) {
        showAlert('Please enter a category name', 'error');
        return;
    }
    
    // For now, categories are created when adding FAQs
    // In a real system, you might have a dedicated category table
    showAlert('Add category while creating a new FAQ', 'info');
}

// ============ CHAT LOGS ============

function loadChatLogs() {
    const formData = new FormData();
    formData.append('action', 'get_chat_logs');
    formData.append('limit', 50);
    formData.append('offset', 0);
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayChatLogsTable(data.logs);
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayChatLogsTable(logs) {
    let html = `
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Messages</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    logs.forEach(log => {
        const date = new Date(log.created_at).toLocaleDateString();
        html += `
            <tr>
                <td>${log.user_name || 'Guest'}</td>
                <td>${log.email || 'N/A'}</td>
                <td>${log.message_count || 0}</td>
                <td>${date}</td>
                <td>
                    <button class="btn btn-primary" onclick="viewConversation(${log.id})">View</button>
                </td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
    `;
    
    document.getElementById('logsTable').innerHTML = html;
}

function viewConversation(conversationId) {
    const formData = new FormData();
    formData.append('action', 'get_conversation');
    formData.append('id', conversationId);
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayConversationMessages(data.messages);
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayConversationMessages(messages) {
    let html = '<div style="background: #f5f7fa; padding: 15px; border-radius: 5px; margin-top: 20px;">';
    
    messages.forEach(msg => {
        const time = new Date(msg.created_at).toLocaleTimeString();
        const senderClass = msg.sender === 'user' ? 'background: #667eea; color: white;' : 'background: #e8e8e8; color: #333;';
        
        html += `
            <div style="margin-bottom: 10px; padding: 10px; border-radius: 5px; ${senderClass}">
                <strong>${msg.sender.toUpperCase()}</strong> (${time})<br>
                ${msg.message}
            </div>
        `;
    });
    
    html += '</div>';
    document.getElementById('logsTable').innerHTML = html;
}

// ============ ANALYTICS ============

function loadAnalytics() {
    const formData = new FormData();
    formData.append('action', 'get_most_asked');
    formData.append('limit', 10);
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayAnalyticsTable(data.questions);
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayAnalyticsTable(questions) {
    let html = `
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Times Asked</th>
                    <th>Last Asked</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    questions.forEach(q => {
        const lastAsked = new Date(q.last_asked).toLocaleString();
        html += `
            <tr>
                <td>${q.question}</td>
                <td><strong>${q.ask_count}</strong></td>
                <td>${lastAsked}</td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
    `;
    
    if (questions.length === 0) {
        html = '<p style="color: #999; margin-top: 20px;">No analytics data yet</p>';
    }
    
    document.getElementById('analyticsTable').innerHTML = html;
}

// ============ ANNOUNCEMENTS ============

function loadAnnouncements() {
    const formData = new FormData();
    formData.append('action', 'get_announcements');
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            displayAnnouncementsTable(data.announcements);
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayAnnouncementsTable(announcements) {
    let html = `
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created By</th>
                    <th>Created Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    announcements.forEach(ann => {
        const date = new Date(ann.created_at).toLocaleDateString();
        const status = ann.is_active ? 'Active' : 'Inactive';
        const statusClass = ann.is_active ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;';
        
        html += `
            <tr>
                <td>${ann.title}</td>
                <td>${ann.username || 'System'}</td>
                <td>${date}</td>
                <td><span style="padding: 5px 10px; border-radius: 3px; ${statusClass}">${status}</span></td>
                <td>
                    <button class="btn btn-primary" onclick="editAnnouncement(${ann.id})">Edit</button>
                    <button class="btn btn-secondary" onclick="toggleAnnouncement(${ann.id}, ${ann.is_active ? 0 : 1})">
                        ${ann.is_active ? 'Deactivate' : 'Activate'}
                    </button>
                    <button class="btn btn-danger" onclick="deleteAnnouncement(${ann.id})">Delete</button>
                </td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
    `;
    
    document.getElementById('announcementsTable').innerHTML = html;
}

function showAnnouncementModal() {
    document.getElementById('announcementId').value = '';
    document.getElementById('announcementTitle').value = '';
    document.getElementById('announcementContent').value = '';
    document.getElementById('announcementModalTitle').textContent = 'Add Announcement';
    document.getElementById('announcementModal').classList.add('show');
}

function closeAnnouncementModal() {
    document.getElementById('announcementModal').classList.remove('show');
}

function editAnnouncement(id) {
    const formData = new FormData();
    formData.append('action', 'get_announcements');
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const announcement = data.announcements.find(a => a.id == id);
            if (announcement) {
                document.getElementById('announcementId').value = announcement.id;
                document.getElementById('announcementTitle').value = announcement.title;
                document.getElementById('announcementContent').value = announcement.content;
                document.getElementById('announcementModalTitle').textContent = 'Edit Announcement';
                document.getElementById('announcementModal').classList.add('show');
            }
        }
    });
}

function saveAnnouncement() {
    const id = document.getElementById('announcementId').value;
    const title = document.getElementById('announcementTitle').value;
    const content = document.getElementById('announcementContent').value;
    
    const formData = new FormData();
    formData.append('title', title);
    formData.append('content', content);
    
    if (id) {
        formData.append('action', 'update_announcement');
        formData.append('id', id);
    } else {
        formData.append('action', 'add_announcement');
    }
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            closeAnnouncementModal();
            loadAnnouncements();
            showAlert(data.message, 'success');
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => showAlert('Error saving announcement', 'error'));
}

function toggleAnnouncement(id, status) {
    const formData = new FormData();
    formData.append('action', 'toggle_announcement');
    formData.append('id', id);
    formData.append('status', status);
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadAnnouncements();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteAnnouncement(id) {
    if (!confirm('Are you sure you want to delete this announcement?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_announcement');
    formData.append('id', id);
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadAnnouncements();
            showAlert('Announcement deleted', 'success');
        }
    })
    .catch(error => console.error('Error:', error));
}

// ============ UTILITIES ============

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const adminMain = document.querySelector('.admin-main');
    adminMain.insertBefore(alertDiv, adminMain.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

function logout() {
    const formData = new FormData();
    formData.append('action', 'logout');
    
    fetch(getAdminAPIPath(), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('adminPanel').classList.remove('show');
        document.getElementById('loginPage').style.display = 'flex';
        document.getElementById('loginUsername').value = '';
        document.getElementById('loginPassword').value = '';
        currentAdminId = null;
        currentAdminUsername = null;
    })
    .catch(error => console.error('Logout error:', error));
}
