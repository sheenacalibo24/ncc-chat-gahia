<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session BEFORE any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php';
require_once '../models/Admin.php';

$response = ['status' => 'error', 'message' => 'Unknown request', 'debug' => []];

try {
    // Initialize database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    // Check if connection failed
    if (!$conn) {
        $response['message'] = 'Database connection failed - no connection object';
        $response['debug'][] = 'Connection object is null';
        echo json_encode($response);
        exit;
    }
    
    $response['debug'][] = 'Database connection established';
    
    // Check admin authentication
    function checkAdminAuth() {
        if (!isset($_SESSION['admin_id'])) {
            return false;
        }
        return true;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $response['debug'][] = "Action: " . $action;
        
        // Handle check_status (for any user, logged in or not)
        if ($action === 'check_status') {
            if (checkAdminAuth()) {
                $response = ['status' => 'success', 'logged_in' => true, 'username' => $_SESSION['admin_username'], 'debug' => $response['debug']];
            } else {
                $response = ['status' => 'success', 'logged_in' => false, 'debug' => $response['debug']];
            }
        }
        // Login (no auth required)
        elseif ($action === 'login') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            
            $response['debug'][] = "Login attempt with username: " . $username;
            
            // Validate input
            if (empty($username) || empty($password)) {
                $response['message'] = 'Username and password required';
                $response['debug'][] = 'Empty username or password';
            } else {
                try {
                    $admin = new Admin($conn);
                    $result = $admin->loginAdmin($username, $password);
                    $response['debug'][] = "Login result: " . json_encode($result);
                    
                    if ($result['success']) {
                        $_SESSION['admin_id'] = $result['id'];
                        $_SESSION['admin_username'] = $result['username'];
                        $_SESSION['admin_role'] = $result['role'];
                        $_SESSION['logged_in'] = true;
                        $response = ['status' => 'success', 'message' => 'Login successful', 'username' => $result['username'], 'debug' => $response['debug']];
                    } else {
                        $response['message'] = 'Invalid username or password';
                        $response['debug'][] = 'Authentication failed';
                    }
                } catch (Exception $e) {
                    $response['message'] = 'Login error: ' . $e->getMessage();
                    $response['debug'][] = 'Exception: ' . $e->getMessage();
                    $response['debug'][] = 'File: ' . $e->getFile();
                    $response['debug'][] = 'Line: ' . $e->getLine();
                }
            }
        }
        // All other actions require authentication
        elseif (checkAdminAuth()) {
            $response['debug'][] = "Authenticated user: " . $_SESSION['admin_username'];
            
            try {
                $admin = new Admin($conn);
                
                switch ($action) {
                    case 'get_stats':
                        $stats = $admin->getTotalStats();
                        $response = ['status' => 'success', 'stats' => $stats, 'debug' => $response['debug']];
                        break;
                        
                    case 'get_all_faqs':
                        $faqs = $admin->getAllFAQs();
                        $response = ['status' => 'success', 'faqs' => $faqs, 'debug' => $response['debug']];
                        break;
                        
                    case 'get_categories':
                        $categories = $admin->getAllCategories();
                        $response = ['status' => 'success', 'categories' => $categories, 'debug' => $response['debug']];
                        break;
                        
                    default:
                        $response['message'] = 'Unknown action: ' . $action;
                        $response['debug'][] = 'Unhandled action';
                        break;
                }
            } catch (Exception $e) {
                $response['message'] = 'Error: ' . $e->getMessage();
                $response['debug'][] = 'Exception: ' . $e->getMessage();
                $response['debug'][] = 'File: ' . $e->getFile();
                $response['debug'][] = 'Line: ' . $e->getLine();
            }
        } else {
            $response['message'] = 'Unauthorized access';
            $response['debug'][] = 'User not authenticated';
        }
    } else {
        $response['message'] = 'Invalid request method';
        $response['debug'][] = 'Method: ' . $_SERVER['REQUEST_METHOD'];
    }
    
} catch (Exception $e) {
    $response['message'] = 'Critical error: ' . $e->getMessage();
    $response['debug'][] = 'File: ' . $e->getFile();
    $response['debug'][] = 'Line: ' . $e->getLine();
}

echo json_encode($response);

?>
