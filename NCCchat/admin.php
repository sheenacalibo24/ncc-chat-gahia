<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCC Admin Panel - Chatbot Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
        }
        
        /* Login Page */
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        
        .login-box h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .login-box .form-group {
            margin-bottom: 20px;
        }
        
        .login-box label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .login-box input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .login-box button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .login-box button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .login-box .error {
            color: #dc3545;
            margin-top: 20px;
            padding: 10px;
            background: #f8d7da;
            border-radius: 5px;
        }
        
        /* Admin Dashboard */
        .admin-container {
            display: none;
        }
        
        .admin-container.show {
            display: flex;
        }
        
        .admin-sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }
        
        .admin-sidebar h2 {
            margin-bottom: 30px;
            font-size: 18px;
        }
        
        .admin-sidebar ul {
            list-style: none;
        }
        
        .admin-sidebar li {
            margin-bottom: 10px;
        }
        
        .admin-sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
            border-radius: 5px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .admin-main {
            margin-left: 250px;
            padding: 20px;
        }
        
        .admin-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .admin-header h1 {
            color: #333;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }
        
        /* Content Sections */
        .content-section {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .content-section.active {
            display: block;
        }
        
        /* Tables */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th {
            background: #f5f7fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        table tr:hover {
            background: #f9f9f9;
        }
        
        /* Buttons */
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            margin-right: 5px;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5568d3;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .modal-header h2 {
            color: #333;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        
        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 60px;
            }
            
            .admin-main {
                margin-left: 60px;
            }
            
            .admin-sidebar a {
                padding: 12px 5px;
                text-align: center;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Login Page -->
    <div class="login-container" id="loginPage">
        <div class="login-box">
            <h1>🔐 NCC Admin Login</h1>
            <form id="loginForm">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="loginUsername" placeholder="admin" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="loginPassword" placeholder="••••••••" required>
                </div>
                <button type="submit">Login</button>
                <div id="loginError" class="error" style="display: none;"></div>
            </form>
            <p style="text-align: center; margin-top: 20px; color: #666;">
                Default: admin / ncc123456
            </p>
        </div>
    </div>

    <!-- Admin Dashboard -->
    <div class="admin-container" id="adminPanel">
        <div class="admin-sidebar">
            <h2>NCC Admin</h2>
            <ul>
                <li><a onclick="switchSection('dashboard', this)" class="active"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a onclick="switchSection('faqs', this)"><i class="fas fa-question-circle"></i> FAQs</a></li>
                <li><a onclick="switchSection('categories', this)"><i class="fas fa-list"></i> Categories</a></li>
                <li><a onclick="switchSection('logs', this)"><i class="fas fa-comments"></i> Chat Logs</a></li>
                <li><a onclick="switchSection('analytics', this)"><i class="fas fa-bar-chart"></i> Analytics</a></li>
                <li><a onclick="switchSection('announcements', this)"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                <li style="margin-top: 30px;"><a onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="admin-main">
            <!-- Header -->
            <div class="admin-header">
                <h1 id="sectionTitle">Dashboard</h1>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>

            <!-- Dashboard Section -->
            <div class="content-section active" id="dashboardSection">
                <h2>📊 Dashboard</h2>
                <div class="dashboard-grid">
                    <div class="stat-card">
                        <h3>Total Conversations</h3>
                        <div class="value" id="statConversations">0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Messages</h3>
                        <div class="value" id="statMessages">0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total FAQs</h3>
                        <div class="value" id="statFAQs">0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Today's Chats</h3>
                        <div class="value" id="statToday">0</div>
                    </div>
                </div>
            </div>

            <!-- FAQs Section -->
            <div class="content-section" id="faqsSection">
                <h2>📚 Manage FAQs</h2>
                <button class="btn btn-primary" onclick="showFAQModal()"><i class="fas fa-plus"></i> Add FAQ</button>
                <div class="table-container" id="faqsTable"></div>
            </div>

            <!-- Categories Section -->
            <div class="content-section" id="categoriesSection">
                <h2>📂 Manage Categories</h2>
                <div class="form-group">
                    <label>Category Name</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="newCategory" placeholder="Enter new category">
                        <button class="btn btn-primary" onclick="addCategory()">Add</button>
                    </div>
                </div>
                <div id="categoriesList"></div>
            </div>

            <!-- Chat Logs Section -->
            <div class="content-section" id="logsSection">
                <h2>💬 Chat Logs</h2>
                <div class="table-container" id="logsTable"></div>
            </div>

            <!-- Analytics Section -->
            <div class="content-section" id="analyticsSection">
                <h2>📈 Most Asked Questions</h2>
                <div class="table-container" id="analyticsTable"></div>
            </div>

            <!-- Announcements Section -->
            <div class="content-section" id="announcementsSection">
                <h2>📢 Announcements</h2>
                <button class="btn btn-primary" onclick="showAnnouncementModal()"><i class="fas fa-plus"></i> Add Announcement</button>
                <div class="table-container" id="announcementsTable"></div>
            </div>
        </div>
    </div>

    <!-- FAQ Modal -->
    <div class="modal" id="faqModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="faqModalTitle">Add FAQ</h2>
                <button class="close-btn" onclick="closeFAQModal()">&times;</button>
            </div>
            <form id="faqForm">
                <input type="hidden" id="faqId">
                <div class="form-group">
                    <label>Category</label>
                    <select id="faqCategory" required></select>
                </div>
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" id="faqQuestion" required>
                </div>
                <div class="form-group">
                    <label>Answer</label>
                    <textarea id="faqAnswer" required></textarea>
                </div>
                <div class="form-group">
                    <label>Keywords (comma-separated)</label>
                    <input type="text" id="faqKeywords">
                </div>
                <button type="submit" class="btn btn-success">Save FAQ</button>
            </form>
        </div>
    </div>

    <!-- Announcement Modal -->
    <div class="modal" id="announcementModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="announcementModalTitle">Add Announcement</h2>
                <button class="close-btn" onclick="closeAnnouncementModal()">&times;</button>
            </div>
            <form id="announcementForm">
                <input type="hidden" id="announcementId">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" id="announcementTitle" required>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea id="announcementContent" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Save Announcement</button>
            </form>
        </div>
    </div>

    <script src="views/layouts/admin.js"></script>
</body>
</html>
