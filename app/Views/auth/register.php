<?php
$title = 'Register | AuthBoard';
ob_start();
$base = '/metro_wb_lab/public';
?>
<div class="glass-wrapper text-white p-4" style="max-width: 600px; margin: 80px auto;">
  <h2 class="text-center mb-4 fw-semibold">Create Account</h2>

  <form method="POST" action="<?= $base ?>/register" enctype="multipart/form-data">
    
    <!-- Name -->
    <div class="mb-3">
      <label class="form-label fw-semibold">Full Name</label>
      <input 
        type="text" 
        class="form-control bg-transparent text-white border-light" 
        name="name" 
        placeholder="Enter your name"
        required
      >
    </div>

    <!-- Email -->
    <div class="mb-3">
      <label class="form-label fw-semibold">Email Address</label>
      <input 
        type="email" 
        class="form-control bg-transparent text-white border-light" 
        name="email" 
        placeholder="Enter your email"
        required
      >
    </div>

    <!-- Password -->
    <div class="mb-3">
      <label class="form-label fw-semibold">Password</label>
      <input 
        type="password" 
        class="form-control bg-transparent text-white border-light" 
        name="password" 
        placeholder="Create a strong password"
        required
      >
    </div>

    <!-- Profile Picture -->
    <div class="mb-4">
      <label class="form-label fw-semibold">Profile Picture</label>
      <input 
        type="file" 
        class="form-control bg-transparent text-white border-light" 
        name="profile_pic" 
        accept="image/*"
      >
      <small class="text-light">Optional — choose an image to use as your avatar.</small>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
      Register
    </button>
  </form>

  <p class="text-center mt-4 mb-0">
    Already have an account?
    <a href="<?= $base ?>/login" class="text-decoration-underline text-light">Login</a>
  </p>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
