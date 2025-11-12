<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Mailer;
use App\Models\User;

class AuthController extends Controller {

    public function showLogin() {
        $this->view('auth/login.php');
    }

    public function showRegister() {
        $this->view('auth/register.php');
    }

    public function register() {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $profilePicPath = null;

        // ✅ Validate input
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
            return;
        }
        if (strlen($password) < 6) {
            echo "Password must be at least 6 characters.";
            return;
        }

        // ✅ Handle optional profile picture upload
        if (!empty($_FILES['profile_pic']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/profile_pics/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
            $fileName = 'user_' . time() . '.' . strtolower($ext);
            $profilePicPath = 'uploads/profile_pics/' . $fileName;

            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadDir . $fileName);
        }

        // ✅ Hash password and save to DB
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        User::create($name, $email, $hashed, $profilePicPath);

        // ✅ Send welcome email (Mailtrap for dev)
        Mailer::send($email, 'Welcome to AuthBoard', "Hello $name,\n\nThanks for registering at AuthBoard.");

        // ✅ Redirect to login
        header('Location: /metro_wb_lab/public/login');
        exit;
    }

    public function login() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        // ✅ Verify login
        if ($user && password_verify($password, $user['password'])) {
            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'profile_pic' => $user['profile_pic'] ?? null // ✅ store picture in session
            ]);

            header('Location: /metro_wb_lab/public/dashboard');
            exit;
        }

        echo 'Invalid credentials.';
    }

    public function logout() {
        Session::destroy();

        header('Location: /metro_wb_lab/public/login');
        exit;
    }
}
