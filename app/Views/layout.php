<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'AuthBoard' ?></title>

  <!-- ✅ Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Custom Glassmorphism Style -->
  <style>
    body {
      background: url("/metro_wb_lab/public/assets/bbg.jpg") no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding-top: 80px; /* space for navbar */
    }

    /* ✅ Glass Wrapper */
    .glass-wrapper {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(16px);
      border-radius: 25px;
      padding: 2.5rem 2rem;
      box-shadow: 0 8px 35px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 500px;
      height: auto;
      min-height: 500px;
      color: #fff;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      justify-content: center;
      margin: auto;
    }

    .glass-wrapper:hover {
      background: rgba(255, 255, 255, 0.18);
      transform: scale(1.02);
    }

    .glass-wrapper h2 {
      font-weight: 600;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .form-label {
      color: #fff;
      font-weight: 500;
    }

    .btn-primary {
      width: 100%;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    a {
      color: #d0d0ff;
      text-decoration: underline;
    }

    /* ✅ Footer */
    footer {
      position: fixed;
      bottom: 15px;
      width: 100%;
      text-align: center;
      color: rgba(255, 255, 255, 0.7);
      font-size: 0.9rem;
    }

    /* ✅ Input Fields */
    .form-control {
      background: rgba(0, 0, 0, 0.35) !important;
      border: 1px solid rgba(255, 255, 255, 0.63) !important;
      color: #140202ff !important;
      height: 42px;
      font-size: 1rem;
      padding-left: 10px;
    }

    .form-control::placeholder {
      color: rgba(219, 214, 214, 0.7);
    }

    .form-control:focus {
      background: rgba(202, 198, 198, 0.45) !important;
      border-color: #ffffff !important;
      color: #120303ff !important;
      box-shadow: none;
    }

    /* ✅ Navbar Glass Effect */
    .navbar {
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar-brand {
      font-weight: 700;
      color: #fff !important;
    }

    .navbar .btn {
      font-weight: 500;
      letter-spacing: 0.3px;
    }

    /* Centered dashboard container */
    .dashboard-container {
      max-width: 700px;
      margin: 0 auto;
      padding: 0 15px;
    }

    /* Profile Picture */
    .profile-pic {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255, 255, 255, 0.6);
      cursor: pointer;
      transition: 0.3s;
    }
    .profile-pic:hover {
      transform: scale(1.08);
      border-color: #fff;
    }
  </style>
</head>

<body>

  <!-- ✅ Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4 py-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-3">
        <a class="navbar-brand" href="/metro_wb_lab/public/">AuthBoard</a>
        <?php if (!empty($_SESSION['user'])): ?>
          <a href="/metro_wb_lab/public/dashboard" class="btn btn-outline-light btn-sm">Dashboard</a>
        <?php endif; ?>
      </div>

      <?php if (!empty($_SESSION['user'])): ?>
        <div class="d-flex align-items-center gap-3">
          <!-- ✅ Profile Link -->
          <a href="/metro_wb_lab/public/profile" class="btn btn-outline-light btn-sm">Profile</a>

          <!-- ✅ Profile Picture -->
          <img src="/metro_wb_lab/public/<?=
              !empty($_SESSION['user']['profile_pic'])
                ? htmlspecialchars($_SESSION['user']['profile_pic'])
                : 'assets/default.png'
            ?>"
            alt="Profile"
            class="profile-pic"
            onclick="window.location.href='/metro_wb_lab/public/profile';"
          >

          <!-- ✅ Logout -->
          <a href="/metro_wb_lab/public/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
      <?php else: ?>
        <div>
          <a href="/metro_wb_lab/public/login" class="btn btn-outline-light btn-sm me-2">Login</a>
          <a href="/metro_wb_lab/public/register" class="btn btn-light btn-sm">Register</a>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <!-- ✅ Page Content -->
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <?= $content ?>
  </div>

  <!-- ✅ Footer -->
  <footer>
    © <?= date('Y') ?> AuthBoard - A Learning Project
  </footer>

  <!-- ✅ Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
