<?php

class Conversation {
    private $conn;
    
    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }
    
    public function getOrCreateConversation($session_id, $user_name = null, $email = null) {
        $stmt = $this->conn->prepare("SELECT id FROM conversations WHERE session_id = ?");
        $stmt->execute([$session_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['id'];
        } else {
            $stmt = $this->conn->prepare("INSERT INTO conversations (session_id, user_name, email) VALUES (?, ?, ?)");
            $stmt->execute([$session_id, $user_name, $email]);
            return $this->conn->lastInsertId();
        }
    }
    
    public function addMessage($conversation_id, $sender, $message) {
        $stmt = $this->conn->prepare("INSERT INTO messages (conversation_id, sender, message) VALUES (?, ?, ?)");
        return $stmt->execute([$conversation_id, $sender, $message]);
    }
    
    public function getMessages($conversation_id) {
        $stmt = $this->conn->prepare("SELECT sender, message, created_at FROM messages WHERE conversation_id = ? ORDER BY created_at ASC");
        $stmt->execute([$conversation_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
