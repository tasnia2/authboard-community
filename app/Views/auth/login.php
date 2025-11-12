<?php
$title = 'Login | AuthBoard';
ob_start();
$base = '/metro_wb_lab/public';
?>
<div class="glass-wrapper">
  <h2>Welcome Back</h2>
  <form method="POST" action="<?= $base ?>/login">
    <div class="mb-3">
      <label class="form-label">Email address</label>
      <input type="email" class="form-control bg-transparent text-white border-light" name="email" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control bg-transparent text-white border-light" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
  <p class="text-center mt-3 mb-0">Don't have an account?
    <a href="<?= $base ?>/register">Register</a>
  </p>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
