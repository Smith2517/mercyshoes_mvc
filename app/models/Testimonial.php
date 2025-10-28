<?php
class Testimonial {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->ensureTableExists();
    }

    public function latest($limit = 6) {
        $limit = max(1, (int)$limit);
        try {
            $stmt = $this->db->prepare('SELECT id, author_name, rating, comment, created_at FROM testimonials ORDER BY created_at DESC LIMIT :limit');
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            if ($e->getCode() !== '42S02') {
                throw $e;
            }
            return [];
        }
    }

    public function create(array $data) {
        $stmt = $this->db->prepare('INSERT INTO testimonials (author_name, rating, comment) VALUES (:author, :rating, :comment)');
        $stmt->execute([
            ':author' => $data['author_name'],
            ':rating' => $data['rating'],
            ':comment' => $data['comment'],
        ]);
        return $this->db->lastInsertId();
    }

    private function ensureTableExists() {
        $this->db->exec('CREATE TABLE IF NOT EXISTS testimonials (
            id INT AUTO_INCREMENT PRIMARY KEY,
            author_name VARCHAR(120) NOT NULL,
            rating TINYINT NOT NULL DEFAULT 5,
            comment TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )');
    }
}
?>
