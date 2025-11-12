<?php
namespace App\Models;

use PDO;

class Post {
    private static function connect(): PDO {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $db   = getenv('DB_NAME') ?: 'authboard';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    }

    /** ✅ Create new post */
    public static function create(int $userId, string $content, ?string $image = null): int {
        $pdo = self::connect();
        $stmt = $pdo->prepare('INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $content, $image]);
        return (int)$pdo->lastInsertId();
    }

    /** ✅ Get all posts with user info including profile picture */
    public static function getAllWithUsers(): array {
        $pdo = self::connect();
        $stmt = $pdo->prepare('
            SELECT 
                p.*, 
                u.name AS user_name, 
                u.profile_pic
            FROM posts p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.created_at DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** ✅ Get all posts by a specific user (including profile pic) */
    public static function findByUserId(int $userId): array {
        $pdo = self::connect();
        $stmt = $pdo->prepare('
            SELECT 
                p.*, 
                u.name AS user_name, 
                u.profile_pic
            FROM posts p
            JOIN users u ON p.user_id = u.id
            WHERE p.user_id = ?
            ORDER BY p.created_at DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
