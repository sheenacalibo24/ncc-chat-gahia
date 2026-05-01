<?php

class Admin {
    private $conn;
    
    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }
    
    // User Authentication
    public function loginAdmin($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, username, password, role FROM admin_users WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && password_verify($password, $result['password'])) {
            return ['success' => true, 'id' => $result['id'], 'username' => $result['username'], 'role' => $result['role']];
        }
        return ['success' => false];
    }
    
    // FAQ Management
    public function addFAQ($category, $question, $answer, $keywords) {
        $stmt = $this->conn->prepare("INSERT INTO faq (category, question, answer, keywords) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$category, $question, $answer, $keywords]);
    }
    
    public function updateFAQ($id, $category, $question, $answer, $keywords) {
        $stmt = $this->conn->prepare("UPDATE faq SET category = ?, question = ?, answer = ?, keywords = ? WHERE id = ?");
        return $stmt->execute([$category, $question, $answer, $keywords, $id]);
    }
    
    public function deleteFAQ($id) {
        $stmt = $this->conn->prepare("DELETE FROM faq WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getAllFAQs() {
        $result = $this->conn->query("SELECT * FROM faq ORDER BY category, id");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getFAQById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM faq WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Category Management
    public function getAllCategories() {
        $result = $this->conn->query("SELECT DISTINCT category FROM faq ORDER BY category");
        $categories = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row['category'];
        }
        return $categories;
    }
    
    public function addCategory($category) {
        $stmt = $this->conn->prepare("INSERT INTO faq (category, question, answer) VALUES (?, ?, ?)");
        $question = "Sample Question";
        $answer = "Sample Answer";
        return $stmt->execute([$category, $question, $answer]);
    }
    
    // Chat Logs
    public function getChatLogs($limit = 100, $offset = 0) {
        $stmt = $this->conn->prepare("
            SELECT c.id, c.session_id, c.user_name, c.email, c.created_at, 
                   COUNT(m.id) as message_count
            FROM conversations c
            LEFT JOIN messages m ON c.id = m.conversation_id
            GROUP BY c.id
            ORDER BY c.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getConversationMessages($conversation_id) {
        $stmt = $this->conn->prepare("SELECT * FROM messages WHERE conversation_id = ? ORDER BY created_at ASC");
        $stmt->execute([$conversation_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Most Asked Questions
    public function getMostAskedQuestions($limit = 10) {
        $stmt = $this->conn->prepare("
            SELECT question, ask_count, last_asked 
            FROM chat_analytics 
            ORDER BY ask_count DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function trackQuestion($question) {
        $stmt = $this->conn->prepare("
            INSERT INTO chat_analytics (question, ask_count) 
            VALUES (?, 1) 
            ON DUPLICATE KEY UPDATE 
            ask_count = ask_count + 1, 
            last_asked = CURRENT_TIMESTAMP
        ");
        return $stmt->execute([$question]);
    }
    
    public function getTotalStats() {
        $stats = [];
        
        // Total conversations
        $result = $this->conn->query("SELECT COUNT(*) as count FROM conversations");
        $stats['total_conversations'] = $result->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Total messages
        $result = $this->conn->query("SELECT COUNT(*) as count FROM messages");
        $stats['total_messages'] = $result->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Total FAQ
        $result = $this->conn->query("SELECT COUNT(*) as count FROM faq");
        $stats['total_faqs'] = $result->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Today's conversations
        $result = $this->conn->query("SELECT COUNT(*) as count FROM conversations WHERE DATE(created_at) = CURDATE()");
        $stats['today_conversations'] = $result->fetch(PDO::FETCH_ASSOC)['count'];
        
        return $stats;
    }
    
    // Announcements
    public function addAnnouncement($title, $content, $created_by) {
        $stmt = $this->conn->prepare("INSERT INTO announcements (title, content, created_by) VALUES (?, ?, ?)");
        return $stmt->execute([$title, $content, $created_by]);
    }
    
    public function updateAnnouncement($id, $title, $content) {
        $stmt = $this->conn->prepare("UPDATE announcements SET title = ?, content = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $id]);
    }
    
    public function deleteAnnouncement($id) {
        $stmt = $this->conn->prepare("DELETE FROM announcements WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getAnnouncements() {
        $result = $this->conn->query("
            SELECT a.*, u.username 
            FROM announcements a 
            LEFT JOIN admin_users u ON a.created_by = u.id 
            WHERE a.is_active = 1 
            ORDER BY a.created_at DESC
        ");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAnnouncementById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM announcements WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function toggleAnnouncement($id, $status) {
        $stmt = $this->conn->prepare("UPDATE announcements SET is_active = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}

?>
