<?php

class FAQ {
    private $conn;
    
    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }
    
    public function searchFAQ($query) {
        $search_term = '%' . $query . '%';
        $stmt = $this->conn->prepare(
            "SELECT id, category, question, answer FROM faq 
             WHERE question LIKE ? OR keywords LIKE ? OR answer LIKE ?
             LIMIT 5"
        );
        $stmt->execute([$search_term, $search_term, $search_term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllFAQ() {
        $result = $this->conn->query("SELECT id, category, question, answer FROM faq ORDER BY category, id");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getFAQByCategory($category) {
        $stmt = $this->conn->prepare("SELECT id, question, answer FROM faq WHERE category = ? ORDER BY id");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
