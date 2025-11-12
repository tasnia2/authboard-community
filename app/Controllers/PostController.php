<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Post;
use App\Models\Like;


class PostController extends Controller
{
    // Show all posts
    public function showPosts()
    {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /metro_wb_lab/public/login');
            exit;
        }

        $posts = Post::getAllWithUsers();
        $this->view('posts/posts.php', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    // Show the "Create Post" form
    public function showCreatePost()
    {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /metro_wb_lab/public/login');
            exit;
        }

        $this->view('posts/create.php', ['user' => $user]);
    }

    // Handle post submission
    public function createPost()
    {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /metro_wb_lab/public/login');
            exit;
        }

        $content = trim($_POST['content'] ?? '');
        $image = $_FILES['image'] ?? null;

        if (empty($content)) {
            echo "⚠️ Content cannot be empty.";
            return;
        }

        $imagePath = null;

        // Handle image upload if provided
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            $fileName = uniqid('post_', true) . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/' . $fileName;
            } else {
                echo "❌ Failed to upload image.";
                return;
            }
        }

        // Save post to database
        Post::create($user['id'], $content, $imagePath);

        // Redirect to posts page or dashboard
        header('Location: /metro_wb_lab/public/dashboard');
        exit;
    }
    /** ✅ Like a post */
public function likePost() {
    $user = \App\Core\Session::get('user');
    $postId = (int)($_POST['post_id'] ?? 0);

    if ($user && $postId) {
        Like::likePost($user['id'], $postId);
    }

    header('Location: /metro_wb_lab/public/dashboard');
    exit;
}

/** ✅ Unlike a post */
public function unlikePost() {
    $user = \App\Core\Session::get('user');
    $postId = (int)($_POST['post_id'] ?? 0);

    if ($user && $postId) {
        Like::unlikePost($user['id'], $postId);
    }

    header('Location: /metro_wb_lab/public/dashboard');
    exit;
}

}
