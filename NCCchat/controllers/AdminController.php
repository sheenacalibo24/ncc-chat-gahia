<?php
header('Content-Type: application/json');

// Start session BEFORE any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php';
require_once '../models/Admin.php';

$response = ['status' => 'error', 'message' => 'Unknown request'];

// Initialize database connection
$database = new Database();
$conn = $database->getConnection();

// Check if connection failed
if (!$conn) {
    $response = ['status' => 'error', 'message' => 'Database connection failed'];
    echo json_encode($response);
    exit;
}

// Check admin authentication
function checkAdminAuth() {
    if (!isset($_SESSION['admin_id'])) {
        return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $admin = new Admin($conn);
    
    // Login (no auth required)
    if ($action === 'login') {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        
        // Validate input
        if (empty($username) || empty($password)) {
            $response = ['status' => 'error', 'message' => 'Username and password required'];
        } else {
            $result = $admin->loginAdmin($username, $password);
            if ($result['success']) {
                $_SESSION['admin_id'] = $result['id'];
                $_SESSION['admin_username'] = $result['username'];
                $_SESSION['admin_role'] = $result['role'];
                $_SESSION['logged_in'] = true;
                $response = ['status' => 'success', 'message' => 'Login successful', 'username' => $result['username']];
            } else {
                $response = ['status' => 'error', 'message' => 'Invalid username or password'];
            }
        }
    }
    // Logout
    elseif ($action === 'logout') {
        session_destroy();
        $response = ['status' => 'success', 'message' => 'Logged out'];
    }
    // All other actions require authentication
    elseif (checkAdminAuth()) {
        switch ($action) {
            // FAQ Management
            case 'add_faq':
                $category = isset($_POST['category']) ? $_POST['category'] : '';
                $question = isset($_POST['question']) ? $_POST['question'] : '';
                $answer = isset($_POST['answer']) ? $_POST['answer'] : '';
                $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
                
                if ($admin->addFAQ($category, $question, $answer, $keywords)) {
                    $response = ['status' => 'success', 'message' => 'FAQ added successfully'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to add FAQ'];
                }
                break;
                
            case 'update_faq':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                $category = isset($_POST['category']) ? $_POST['category'] : '';
                $question = isset($_POST['question']) ? $_POST['question'] : '';
                $answer = isset($_POST['answer']) ? $_POST['answer'] : '';
                $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
                
                if ($admin->updateFAQ($id, $category, $question, $answer, $keywords)) {
                    $response = ['status' => 'success', 'message' => 'FAQ updated successfully'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to update FAQ'];
                }
                break;
                
            case 'delete_faq':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                if ($admin->deleteFAQ($id)) {
                    $response = ['status' => 'success', 'message' => 'FAQ deleted successfully'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete FAQ'];
                }
                break;
                
            case 'get_all_faqs':
                $faqs = $admin->getAllFAQs();
                $response = ['status' => 'success', 'faqs' => $faqs];
                break;
                
            case 'get_faq':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                $faq = $admin->getFAQById($id);
                $response = ['status' => 'success', 'faq' => $faq];
                break;
                
            // Category Management
            case 'get_categories':
                $categories = $admin->getAllCategories();
                $response = ['status' => 'success', 'categories' => $categories];
                break;
                
            // Chat Logs
            case 'get_chat_logs':
                $limit = isset($_POST['limit']) ? $_POST['limit'] : 50;
                $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
                $logs = $admin->getChatLogs($limit, $offset);
                $response = ['status' => 'success', 'logs' => $logs];
                break;
                
            case 'get_conversation':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                $messages = $admin->getConversationMessages($id);
                $response = ['status' => 'success', 'messages' => $messages];
                break;
                
            // Analytics
            case 'get_most_asked':
                $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
                $questions = $admin->getMostAskedQuestions($limit);
                $response = ['status' => 'success', 'questions' => $questions];
                break;
                
            case 'get_stats':
                $stats = $admin->getTotalStats();
                $response = ['status' => 'success', 'stats' => $stats];
                break;
                
            // Announcements
            case 'add_announcement':
                $title = isset($_POST['title']) ? $_POST['title'] : '';
                $content = isset($_POST['content']) ? $_POST['content'] : '';
                
                if ($admin->addAnnouncement($title, $content, $_SESSION['admin_id'])) {
                    $response = ['status' => 'success', 'message' => 'Announcement added'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to add announcement'];
                }
                break;
                
            case 'update_announcement':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                $title = isset($_POST['title']) ? $_POST['title'] : '';
                $content = isset($_POST['content']) ? $_POST['content'] : '';
                
                if ($admin->updateAnnouncement($id, $title, $content)) {
                    $response = ['status' => 'success', 'message' => 'Announcement updated'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to update announcement'];
                }
                break;
                
            case 'delete_announcement':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                if ($admin->deleteAnnouncement($id)) {
                    $response = ['status' => 'success', 'message' => 'Announcement deleted'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete announcement'];
                }
                break;
                
            case 'get_announcements':
                $announcements = $admin->getAnnouncements();
                $response = ['status' => 'success', 'announcements' => $announcements];
                break;
                
            case 'toggle_announcement':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                $status = isset($_POST['status']) ? $_POST['status'] : 0;
                if ($admin->toggleAnnouncement($id, $status)) {
                    $response = ['status' => 'success', 'message' => 'Announcement status updated'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to update status'];
                }
                break;
        }
    }
    // Check status (for any user, logged in or not)
    elseif ($action === 'check_status') {
        if (checkAdminAuth()) {
            $response = ['status' => 'success', 'logged_in' => true, 'username' => $_SESSION['admin_username']];
        } else {
            $response = ['status' => 'success', 'logged_in' => false];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Unauthorized access'];
    }
}

echo json_encode($response);

?>
