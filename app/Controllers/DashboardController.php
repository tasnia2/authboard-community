<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Post;

class DashboardController extends Controller {
    public function index() {
        $user = Session::get('user');
        if (!$user) { header('Location: /metro_wb_lab/public/login'); exit; }

        $posts = Post::getAllWithUsers();
        $this->view('dashboard.php', compact('user', 'posts'));
    }
}
