<?php
namespace App\Models;

use PDO;

class Like {
    private static function connect(): PDO {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $db   = getenv('DB_NAME') ?: 'authboard';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    /**Add like */
    public static function likePost(int $userId, int $postId): void {
        $pdo = self::connect();
        $stmt = $pdo->prepare('INSERT IGNORE INTO likes (user_id, post_id) VALUES (?, ?)');
        $stmt->execute([$userId, $postId]);
    }

    /**Remove like */
    public static function unlikePost(int $userId, int $postId): void {
        $pdo = self::connect();
        $stmt = $pdo->prepare('DELETE FROM likes WHERE user_id = ? AND post_id = ?');
        $stmt->execute([$userId, $postId]);
    }

    /** Check if user already liked */
    public static function isLiked(int $userId, int $postId): bool {
        $pdo = self::connect();
        $stmt = $pdo->prepare('SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?');
        $stmt->execute([$userId, $postId]);
        return (bool) $stmt->fetch();
    }

    /** Count total likes on post */
    public static function countLikes(int $postId): int {
        $pdo = self::connect();
        $stmt = $pdo->prepare('SELECT COUNT(*) as total FROM likes WHERE post_id = ?');
        $stmt->execute([$postId]);
        return (int) $stmt->fetchColumn();
    }
}
