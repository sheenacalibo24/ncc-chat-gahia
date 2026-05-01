<?php
header('Content-Type: application/json');
require_once '../config/db.php';
require_once '../models/Conversation.php';
require_once '../models/FAQ.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $session_id = isset($_POST['session_id']) ? $_POST['session_id'] : uniqid();
    
    $conversation = new Conversation($conn);
    $faq = new FAQ($conn);
    
    switch ($action) {
        case 'send_message':
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : 'Guest';
            
            if (empty($message)) {
                $response = ['status' => 'error', 'message' => 'Message cannot be empty'];
                break;
            }
            
            $conv_id = $conversation->getOrCreateConversation($session_id, $user_name);
            
            // Save user message
            $conversation->addMessage($conv_id, 'user', $message);
            
            // Search FAQ for answer
            $faq_results = $faq->searchFAQ($message);
            
            // Generate bot response
            $bot_message = generateBotResponse($message, $faq_results);
            
            // Save bot message
            $conversation->addMessage($conv_id, 'bot', $bot_message);
            
            $response = [
                'status' => 'success',
                'session_id' => $session_id,
                'conversation_id' => $conv_id,
                'bot_response' => $bot_message,
                'faq_matches' => count($faq_results)
            ];
            break;
            
        case 'get_messages':
            $conv_id = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : null;
            
            if ($conv_id) {
                $messages = $conversation->getMessages($conv_id);
                $response = [
                    'status' => 'success',
                    'messages' => $messages
                ];
            }
            break;
            
        case 'search_faq':
            $query = isset($_POST['query']) ? $_POST['query'] : '';
            
            if (!empty($query)) {
                $results = $faq->searchFAQ($query);
                $response = [
                    'status' => 'success',
                    'results' => $results
                ];
            } else {
                $response = ['status' => 'error', 'message' => 'Empty search query'];
            }
            break;
            
        case 'get_categories':
            $result = $conn->query("SELECT DISTINCT category FROM faq ORDER BY category");
            $categories = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = $row['category'];
            }
            $response = ['status' => 'success', 'categories' => $categories];
            break;
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'get_faq':
            $category = isset($_GET['category']) ? $_GET['category'] : '';
            $faq = new FAQ($conn);
            
            if (!empty($category)) {
                $results = $faq->getFAQByCategory($category);
            } else {
                $results = $faq->getAllFAQ();
            }
            
            $response = [
                'status' => 'success',
                'faqs' => $results
            ];
            break;
    }
}

echo json_encode($response);

function generateBotResponse($user_message, $faq_results) {
    $message_lower = strtolower($user_message);
    
    // Greeting responses
    if (preg_match('/hello|hi|hey|good morning|good afternoon|good evening/i', $message_lower)) {
        return "Hello! 👋 Welcome to NCC (Northeastern Cebu Colleges) Chatbot. How can I help you today? Feel free to ask me about admissions, programs, tuition, campus life, or any other school information!";
    }
    
    // Help responses
    if (preg_match('/help|what can you do|how does this work/i', $message_lower)) {
        return "I can help you with:\n• Admissions & Requirements\n• Academic Programs\n• Tuition & Scholarships\n• Campus Life & Facilities\n• Contact Information\n\nJust ask me any questions about NCC!";
    }
    
    // Thank you responses
    if (preg_match('/thank|thanks|thank you/i', $message_lower)) {
        return "You're welcome! 😊 If you have more questions, feel free to ask. We're here to help!";
    }
    
    // If FAQ match found
    if (!empty($faq_results)) {
        $answer = $faq_results[0]['answer'];
        $response = "Based on your question:\n\n" . $answer;
        
        if (count($faq_results) > 1) {
            $response .= "\n\nI found " . count($faq_results) . " relevant topics. Would you like to know more about something specific?";
        }
        return $response;
    }
    
    // Default response
    return "Thank you for your question! 😊 I don't have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?";
}

?>
