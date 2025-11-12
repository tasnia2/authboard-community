<?php
declare(strict_types=1);

// autoload
require __DIR__ . '/../vendor/autoload.php';

// tiny .env loader (reads .env into getenv and $_ENV)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        [$key, $val] = array_map('trim', explode('=', $line, 2) + [1 => null]);
        if ($key && $val !== null) {
            putenv("$key=$val");
            $_ENV[$key] = $val;
        }
    }
}

use App\Core\Router;
use App\Core\Session;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\PostController;

Session::start();

$router = new Router();
$auth = new AuthController();
$dash = new DashboardController();
$post = new PostController(); // ✅ Added

// ---- AUTH ROUTES ----
$router->get('/', fn() => $auth->showLogin());
$router->get('/login', fn() => $auth->showLogin());
$router->get('/register', fn() => $auth->showRegister());
$router->post('/register', fn() => $auth->register());
$router->post('/login', fn() => $auth->login());
$router->get('/logout', fn() => $auth->logout());

// ---- DASHBOARD ----
$router->get('/dashboard', fn() => $dash->index());

// ---- POST ROUTES ----
$router->post('/create-post', fn() => $post->createPost());
$router->get('/posts', fn() => $post->showPosts());
$router->get('/create-post', fn() => $post->showCreatePost());

// ✅ LIKE/UNLIKE ROUTES — must be BEFORE dispatch
$router->post('/post/like', fn() => $post->likePost());
$router->post('/post/unlike', fn() => $post->unlikePost());

// ---- DISPATCH ----
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$uri = str_replace(['/metro_wb_lab/public', '/metro_wb_lab'], '', $uri);
$router->dispatch($uri, $_SERVER['REQUEST_METHOD'] ?? 'GET');
