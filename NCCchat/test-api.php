<!DOCTYPE html>
<html>
<head>
    <title>NCC Admin - API Test</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 900px; margin: 0 auto; }
        .test { border: 1px solid #ccc; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { border-color: green; background: #f0fff0; }
        .error { border-color: red; background: #fff0f0; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; }
        pre { background: #f5f5f5; padding: 10px; overflow-x: auto; border-radius: 3px; }
        .loading { color: orange; }
        .spinner { display: inline-block; border: 3px solid #f3f3f3; border-top: 3px solid #667eea; border-radius: 50%; width: 20px; height: 20px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <h1>🔍 NCC Admin Dashboard - API Test Suite</h1>
    <hr>
    
    <div class="test">
        <h2>Test 1: Check JavaScript Loading</h2>
        <button onclick="testJSLoading()">Test</button>
        <div id="test1-result"></div>
    </div>

    <div class="test">
        <h2>Test 2: API Connection Test</h2>
        <button onclick="testAPIConnection()">Test API Connection</button>
        <div id="test2-result"></div>
    </div>

    <div class="test">
        <h2>Test 3: Check Status (No Login)</h2>
        <button onclick="testCheckStatus()">Test Status</button>
        <div id="test3-result"></div>
    </div>

    <div class="test">
        <h2>Test 4: Login Test</h2>
        <button onclick="testLogin()">Test Login (admin/ncc123456)</button>
        <div id="test4-result"></div>
    </div>

    <div class="test">
        <h2>Test 5: Get Stats (Requires Login)</h2>
        <button onclick="testGetStats()">Get Stats</button>
        <div id="test5-result"></div>
    </div>

    <div class="test">
        <h2>Test 6: Database Connection</h2>
        <button onclick="testDatabase()">Test DB Connection</button>
        <div id="test6-result"></div>
    </div>

    <div class="test">
        <h2>Test 7: Full Admin JS Loading</h2>
        <button onclick="testFullLoad()">Load Admin JS</button>
        <div id="test7-result"></div>
    </div>

    <div class="test">
        <h2>Navigation</h2>
        <button onclick="window.location.href='admin.php'">Go to Admin Dashboard</button>
        <button onclick="window.location.href='index.php'">Go to Chatbot</button>
    </div>

    <script>
    function showResult(elementId, success, message, data = null) {
        const elem = document.getElementById(elementId);
        elem.className = success ? 'success' : 'error';
        let html = '<p>' + (success ? '✅ ' : '❌ ') + message + '</p>';
        if (data) {
            html += '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        }
        elem.innerHTML = html;
    }

    function testJSLoading() {
        const elem = document.getElementById('test1-result');
        elem.innerHTML = '<p class="loading"><span class="spinner"></span> Testing...</p>';
        
        // Check if admin.js would load
        const adminJsPath = './views/layouts/admin.js';
        fetch(adminJsPath, { method: 'HEAD' })
            .then(response => {
                if (response.ok) {
                    showResult('test1-result', true, 'admin.js file exists and is accessible', { file: adminJsPath, status: response.status });
                } else {
                    showResult('test1-result', false, 'admin.js returned status: ' + response.status, { file: adminJsPath, status: response.status });
                }
            })
            .catch(error => showResult('test1-result', false, 'Failed to access admin.js: ' + error.message, { error: error.message }));
    }

    function testAPIConnection() {
        const elem = document.getElementById('test2-result');
        elem.innerHTML = '<p class="loading"><span class="spinner"></span> Testing...</p>';
        
        fetch('./controllers/AdminController.php', { method: 'HEAD' })
            .then(response => {
                showResult('test2-result', response.ok, 'AdminController.php accessible - Status: ' + response.status, 
                    { file: './controllers/AdminController.php', status: response.status });
            })
            .catch(error => showResult('test2-result', false, 'Failed to connect: ' + error.message, { error: error.message }));
    }

    function testCheckStatus() {
        const elem = document.getElementById('test3-result');
        elem.innerHTML = '<p class="loading"><span class="spinner"></span> Testing...</p>';
        
        const formData = new FormData();
        formData.append('action', 'check_status');
        
        fetch('./controllers/AdminController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const success = data.status === 'success';
            showResult('test3-result', success, 'Check Status: ' + (data.logged_in ? 'LOGGED IN' : 'NOT LOGGED IN'), data);
        })
        .catch(error => showResult('test3-result', false, 'API Error: ' + error.message, { error: error.message }));
    }

    function testLogin() {
        const elem = document.getElementById('test4-result');
        elem.innerHTML = '<p class="loading"><span class="spinner"></span> Logging in...</p>';
        
        const formData = new FormData();
        formData.append('action', 'login');
        formData.append('username', 'admin');
        formData.append('password', 'ncc123456');
        
        fetch('./controllers/AdminController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const success = data.status === 'success';
            showResult('test4-result', success, 'Login: ' + (success ? 'SUCCESS' : 'FAILED'), data);
        })
        .catch(error => showResult('test4-result', false, 'Login Error: ' + error.message, { error: error.message }));
    }

    function testGetStats() {
        const elem = document.getElementById('test5-result');
        elem.innerHTML = '<p class="loading"><span class="spinner"></span> Loading stats...</p>';
        
        const formData = new FormData();
        formData.append('action', 'get_stats');
        
        fetch('./controllers/AdminController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const success = data.status === 'success';
            showResult('test5-result', success, success ? 'Stats loaded successfully' : 'Failed to load stats', data);
        })
        .catch(error => showResult('test5-result', false, 'Error: ' + error.message, { error: error.message }));
    }

    function testDatabase() {
        const elem = document.getElementById('test6-result');
        elem.innerHTML = '<p class="loading"><span class="spinner"></span> Testing...</p>';
        
        fetch('./test-admin-connection.php')
            .then(response => response.text())
            .then(data => {
                const hasConnected = data.includes('✅ Database connection successful');
                showResult('test6-result', hasConnected, hasConnected ? 'Database connected' : 'See test-admin-connection.php for details', 
                    { message: 'Check test-admin-connection.php for full diagnostics' });
            })
            .catch(error => showResult('test6-result', false, 'Error: ' + error.message));
    }

    function testFullLoad() {
        const elem = document.getElementById('test7-result');
        elem.innerHTML = '<p class="loading"><span class="spinner"></span> Loading admin.js...</p>';
        
        // Load the admin.js script
        const script = document.createElement('script');
        script.src = './views/layouts/admin.js?t=' + Date.now();
        script.onload = function() {
            showResult('test7-result', true, 'admin.js loaded successfully', 
                { functions: ['checkAdminStatus', 'loginAdmin', 'loadDashboard'].filter(f => typeof window[f] === 'function') });
        };
        script.onerror = function() {
            showResult('test7-result', false, 'Failed to load admin.js', { error: 'Script load error' });
        };
        document.head.appendChild(script);
    }

    // Auto-run some tests on page load
    window.addEventListener('load', function() {
        console.log('Test page loaded. Running basic tests...');
        testJSLoading();
        testAPIConnection();
    });
    </script>
</body>
</html>
