<?php
$title = 'Dashboard | AuthBoard';
ob_start();
$base = '/metro_wb_lab/public';
use App\Models\Like;
?>

<!-- ✅ DASHBOARD PAGE WRAPPER -->
<div class="dashboard-container py-5">

  <!-- ✅ CREATE POST SECTION -->
  <div class="create-post glass-wrapper text-white mb-5">
    <h4 class="mb-3 fw-semibold">Create a Post</h4>
    <form action="<?= $base ?>/create-post" method="POST" enctype="multipart/form-data">
      <textarea name="content" class="form-control mb-3" rows="2" placeholder="What's on your mind?" required></textarea>
      <input type="file" name="image" class="form-control mb-3" accept="image/*">
      <button type="submit" class="btn btn-primary w-100 py-2">Post</button>
    </form>
  </div>

  <!-- ✅ POSTS FEED -->
  <div class="posts-section">
    <h4 class="text-white mb-4 fw-semibold text-center">All Posts</h4>

    <?php if (!empty($posts)): ?>
      <?php foreach ($posts as $p): ?>
        <div class="post-card glass-wrapper text-white mb-4 position-relative">

          <!-- Post Header -->
          <div class="d-flex align-items-center mb-3">
            <img
              src="<?= $base . '/' . (!empty($p['profile_pic']) ? htmlspecialchars($p['profile_pic']) : 'assets/default.png') ?>"
              class="rounded-circle me-3"
              width="45"
              height="45"
              alt="User Picture"
              style="object-fit: cover; border: 2px solid rgba(255,255,255,0.5);"
            >
            <div>
              <strong class="text-white"><?= htmlspecialchars($p['user_name'] ?? $p['name'] ?? 'User') ?></strong><br>
              <small class="text-light-50"><?= date('M d, Y h:i A', strtotime($p['created_at'])) ?></small>
            </div>
          </div>

          <!-- Edit/Delete Buttons -->
          <?php if ($p['user_id'] == $user['id']): ?>
            <div class="position-absolute top-0 end-0 mt-2 me-3">
              <a href="<?= $base ?>/post/edit?id=<?= $p['id'] ?>" class="btn btn-outline-info btn-sm me-1">✏️</a>
              <form action="<?= $base ?>/post/delete" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this post?');">🗑️</button>
              </form>
            </div>
          <?php endif; ?>

          <!-- Post Content -->
          <p class="mt-3"><?= nl2br(htmlspecialchars($p['content'])) ?></p>

          <?php if (!empty($p['image'])): ?>
            <img src="<?= $base . '/' . htmlspecialchars($p['image']) ?>" class="img-fluid rounded mb-3" alt="Post Image">
          <?php endif; ?>

          <!-- ✅ Like/Unlike Buttons -->
          <div class="d-flex gap-2 mt-3 align-items-center">
            <?php
              $isLiked = Like::isLiked($user['id'], $p['id']);
              $likeCount = Like::countLikes($p['id']);
            ?>

            <?php if ($isLiked): ?>
              <form action="<?= $base ?>/post/unlike" method="POST" style="display:inline;">
                <input type="hidden" name="post_id" value="<?= $p['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">💔 Unlike (<?= $likeCount ?>)</button>
              </form>
            <?php else: ?>
              <form action="<?= $base ?>/post/like" method="POST" style="display:inline;">
                <input type="hidden" name="post_id" value="<?= $p['id'] ?>">
                <button type="submit" class="btn btn-outline-light btn-sm">❤️ Like (<?= $likeCount ?>)</button>
              </form>
            <?php endif; ?>

            <button class="btn btn-outline-light btn-sm">💬 Comment</button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-light text-center">No posts yet. Create your first one!</p>
    <?php endif; ?>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
